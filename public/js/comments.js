// Get CSRF token from meta tag
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

async function submitComment(postId) {
    const form = document.getElementById(`comment-form-${postId}`);
    const formData = new FormData(form);
    const commentsSection = document.getElementById(`comments-section-${postId}`);
    const toggleButton = document.getElementById(`show-comments-btn-${postId}`);

    try {
        const response = await fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
            },
            body: formData
        });

        if (response.ok) {
            const result = await response.json();
            if (result.message === 'Comment created successfully') {
                // Reload or append the comment to the comments container
                await loadComments(postId);
                updateCommentCount(postId);
                commentsSection.classList.remove('hidden');
                toggleButton.textContent = 'Hide Comments';
                form.reset();
            }
        } else {
            const error = await response.json();
            console.error('Error:', error);
        }
    } catch (error) {
        console.error('Error:', error);
    }
}


async function loadComments(postId) {
    const commentsSection = document.getElementById(`comments-section-${postId}`);
    const response = await fetch(`/posts/${postId}/comments`);
    const comments = await response.json();
    
    // Fetch the Blade template
    const templateResponse = await fetch('/comments/template');
    const templateText = await templateResponse.text();
    
    // Clear existing comments
    commentsSection.innerHTML = '';

    // Populate comments section
    comments.forEach(comment => {
        // Replace placeholders with actual data
        const commentHtml = templateText
            .replace(/\${id}/g, comment.id)
            .replace(/\${post_id}/g, comment.post_id)
            .replace(/\${userName}/g, comment.user.name)
            .replace(/\${userId}/g, comment.user.id)
            .replace(/\${createdAt}/g, new Date(comment.created_at).toLocaleString("en-GB",{day:"numeric", month:"long", year:"numeric", hour:"numeric", minute:"numeric"}))
            .replace(/\${message}/g, comment.message)
            .replace(/\${userId}/g, comment.user.id);

        // Create a DOM element from the HTML string
        const commentBox = document.createElement('div');
        commentBox.innerHTML = commentHtml;
        
        // Conditionally display the actions based on the logged-in user's ID
        const actionsDiv = commentBox.querySelector('.actions');
        if (parseInt(actionsDiv.getAttribute('data-user-id')) !== userId) {
            actionsDiv.style.display = 'none';
        }

        // Conditionally display the edited span if the post has been edited
        const editedSpan = commentBox.querySelector('.edited');
        if (comment.updated_at.localeCompare(comment.created_at) == 1) {
            editedSpan.classList.remove('hidden');
        }
        
        commentsSection.appendChild(commentBox);
    });

    // Change button text
    document.getElementById(`show-comments-btn-${postId}`).textContent = 'Hide Comments';
}

function toggleComments(postId) {
    const commentsSection = document.getElementById(`comments-section-${postId}`);
    const toggleButton = document.getElementById(`show-comments-btn-${postId}`);

    if (commentsSection.classList.contains('hidden')) {
        loadComments(postId);
        commentsSection.classList.remove('hidden');
        toggleButton.textContent = 'Hide Comments';
    } else {
        commentsSection.classList.add('hidden');
        toggleButton.textContent = 'Show Comments';
    }
}

function updateCommentCount(postId) {
    const commentsSection = document.getElementById(`comments-section-${postId}`);
    const commentCount = commentsSection.children.length;
    const toggleButton = document.getElementById(`show-comments-btn-${postId}`);
    
    document.querySelector(`#comment-count-${postId}`).textContent = commentCount;
    if (commentCount == 0) {
        commentsSection.classList.add('hidden');
        toggleButton.textContent = '';
    }

}

function editComment(id) {
    const commentContent = document.getElementById(`comment-content-${id}`);
    const currentMessage = commentContent.innerText;
    commentContent.innerHTML = `
        <textarea id="edit-message-${id}" class="w-full p-2 border rounded">${currentMessage}</textarea>
        <div id="error-message-${id}" class="mt-2"></div>
        <button onclick="saveComment(${id})" class="bg-blue-500 text-white px-4 py-2 rounded mt-2">Save</button>
        <button onclick="cancelEdit(${id}, '${currentMessage}')" class="bg-gray-500 text-white px-4 py-2 rounded mt-2">Cancel</button>
    `;
}

async function saveComment(id) {
    const newMessage = document.getElementById(`edit-message-${id}`).value;
    const commentBox = document.getElementById(`comment-box-${id}`);
    const editedSpan = commentBox.querySelector('.edited');
    const errorContainer = document.getElementById(`error-message-${id}`);

    try {
        const response = await fetch(`/comments/${id}`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ message: newMessage })
        });

        if (response.ok) {
            document.getElementById(`comment-content-${id}`).innerHTML = newMessage;
            editedSpan.classList.remove('hidden');
            errorContainer.innerHTML = ''; // Clear any previous errors
        } else {
            const result = await response.json();
            if (result.errors && result.errors.message) {
                errorContainer.innerHTML = `<div class="text-red-500">${result.errors.message.join(', ')}</div>`;
            } else {
                errorContainer.innerHTML = '<div class="text-red-500">An unexpected error occurred.</div>';
            }
        }
    } catch (error) {
        errorContainer.innerHTML = '<div class="text-red-500">An unexpected error occurred.</div>';
    }
}

function cancelEdit(id, originalMessage) {
    document.getElementById(`comment-content-${id}`).innerHTML = originalMessage;
}

async function deleteComment(id, postId) {
    const response = await fetch(`/comments/${id}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        }
    });

    if (response.ok) {
        document.getElementById(`comment-box-${id}`).parentElement.remove();
        updateCommentCount(postId);
    } else {
        console.error('Failed to delete comment');
        // Optionally handle the error
    }
}
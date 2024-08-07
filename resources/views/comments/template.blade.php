<div class="comment-box mb-2 max-w-lg" id="comment-box-${id}">
    <div class="comment-header flex justify-between items-center">
        <div class="flex items-center">
            <span class="text-blue-800"><a href="/profile/${userId}" >${userName}</a></span>
            <span class="text-gray-600 ml-2 text-sm">on ${createdAt}</span>
            <span class="edited hidden text-gray-600 ml-2 text-sm">&middot;&nbsp;&nbsp;edited </span>
        </div>
        <div class="actions flex space-x-2" data-user-id=${userId}>
            <button class="text-blue-500 hover:text-blue-700" onclick="editComment(${id})">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12h.01M12 12h.01M9 12h.01M3 21v-2.586a1 1 0 01.293-.707l12-12a1 1 0 011.414 0l2.586 2.586a1 1 0 010 1.414l-12 12a1 1 0 01-.707.293H3z"></path>
                </svg>
            </button>
            <button class="text-red-500 hover:text-red-700" onclick="deleteComment(${id},${post_id})">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    </div>
    <div class="comment-content text-gray-700" id="comment-content-${id}">
        ${message}
    </div>
</div>
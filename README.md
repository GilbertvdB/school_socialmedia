# Schoolsocials
 This a work in progress side project building a social media like platform for shools.
 Allowing for communication between teachers, parents and school personel.
 
 My focus is more on the backend part with a little bit of touch at the frontend using tailwind css and js. 
 I tried to also keep in mind things like the seperation of concerns, Solid principle and refactored codes from time to time.

 # Features
 The main feature is the abilty to create a post for a specific group or groups. And have participants of this group to be able to interact with this post through comments  just like on a social media platform.

 For the comments interaction part ive used blade with a lot of js scirpts for an interactive experience on the client side.

 # Other features
 As this is still a work in progress here are some of the available features so far:
 - Administrators can register new students, parents, teachers and other personel.
 - Administrators can create and manage classrooms and post groups.
 - Students can be linked to parents & classrooms.
 - Teacher, personel, parents can be linked to one or mutiple post groups.
 - A Dashboard that shows a feed only for the the posts of the groups a user belongs to in most recent order.
 - A Dashboard feature that shows a feed of an initial 5 posts and loads 5 more on demand when the user scrolls down.
 - A Bookmarked page to view all bookmarked posts.
 - A Post page to create and manage posts.
 - A feature to upload documents or images to a post.
 - Socialmedia action buttons feature attached to a post where users can like, comment, or bookmark.
 - A comment section feature where user can add, edit or delete a comment.
 - Mail notifications for an invitation, setting up password and a notification when a new post is available.

 # Back-end
 For the backend aspect:
 - Ive used Breeze for scafolding authentication. Ive updated and edited a few auth files in the controller and in the vendor folder. An administrator can then register a     user and a create new password link notification.
 - Ive created standard controllers for CRUD. Some return a view, redirectedResponse but also JsonResponse for the js scripts.
 - Ive created models with proper relationships and some have accessor or scope functions.
 - Migrations and factories have been created.
 - FormRequests, Policies have been created.
 - Added Events, Listeners and Notifications for new registered user and new post.
 - Ive created a Trait for uploading and removing files within a post.
 - Ive created a combination of views and blade components for the frontend parts.
 - Created a seperate js file to handle all comments section interaction such as, showing, adding, editing and deleting a comment.
 - Written tests using Pest. In my previous work experience we did not write any test so this is one aspect im still keen on learning and practicing.

# In progress...
Currently writing and adding proper feature and unit tests.


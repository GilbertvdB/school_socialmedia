# Schoolsocials
This is a work-in-progress side project building a social media-like platform for schools, allowing for communication between teachers, parents, and school personnel.

My focus is primarily on the backend, with some frontend development using Tailwind CSS and JavaScript. I’ve also kept in mind principles like separation of concerns, SOLID principles, and regularly refactored code to maintain quality.

# Features
The main feature is the ability to create a post for a specific group or groups, allowing participants of these groups to interact with the post through comments, similar to a social media platform.

For the comments interaction, I've used Blade along with extensive JavaScript to create an interactive experience on the client side.

# Other features
As this is still a work in progress, here are some of the available features so far:
- Administrators can register new students, parents, teachers, and other personnel.
- Administrators can create and manage classrooms and post groups.
- Students can be linked to parents and classrooms.
- Teachers, personnel, and parents can be linked to one or multiple post groups.
- A Dashboard that shows a feed of posts only from the groups a user belongs to, in most recent order.
- A Dashboard feature that shows an initial feed of 5 posts and loads 5 more on demand as the user scrolls down.
- A Bookmark page to view all bookmarked posts.
- A Post page to create and manage posts.
- A feature to upload documents or images to a post.
- Social media action buttons attached to a post, allowing users to like, comment, or bookmark.
- A comment section feature where users can add, edit, or delete comments.
- Email notifications for invitations, password setup, and new post notifications.

 # Back-end
 For the backend aspect:
 - I've used Breeze for scaffolding authentication and made updates to the authentication files in the controller and vendor folder. Administrators can register users and send a password setup notification.
- I've created standard controllers for CRUD operations. Some return views or RedirectResponse, while others return JsonResponse for use with JavaScript scripts.
- I've created models with proper relationships, including accessors and scopes where necessary.
- Migrations and factories have been created.
- FormRequests and Policies have been implemented.
- Events, Listeners, and Notifications have been added for new user registrations and new posts.
- I've created a Trait for uploading and removing files associated with a post.
- I've developed a combination of views and Blade components for the frontend.
- A separate JavaScript file handles all comment section interactions, including showing, adding, editing, and deleting comments.
- I've written tests using Pest. In my previous work experience, we did not write tests, so this is an area I am eager to learn and practice more.
- I've added a database cache service for the post feed on the dashboard. Cache keys are updated on post creation, updates, and deletion. I also created a command and schedule for invalidating and removing expired cache keys from the database.

# In progress...
- Implementing DB cache for the post feed. [Done]
- Currently writing and adding proper feature and unit tests.

# Possible features
- add Encryptable trait to protect users data in the DB.
- implement search feature
- implement filter feature


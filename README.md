Repo contains Spider Task 3-Backend files.
Contains files for the first backend task of Spider Webdev

## **_Note: Screenshots can be found in the img directory of the repo_**
# Instructions to run the files
1. Install and setup WAMP Server
2. Create MySQL Account with username "adminprof" and password "phpiscool"
3. Create a database named "travel"
4. Type the following MySQL commands:
```
CREATE TABLE `users` (
  `id` int(11) PRIMARY AUTO_INCREMENT NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci UNIQUE NOT NULL,
  `password` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE `journals` (
  `id` int(11) PRIMARY AUTO_INCREMENT NOT NULL,
  `title` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `content` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `lat` double NOT NULL,
  `lng` double NOT NULL,
  `image` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `vote` int(11) NOT NULL,
  `date` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `public` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```
5. Create a folder called spidertask3 inside www directory
6. Put all php and css files from this repo into this spidertask3 directory. Start sharing your travel experiences!
# Details about the task
**Software Stack used:** WAMP Stack (Windows+Apache Server+MySQL+PHP)

**Hashing standard**: BCRYPT(password_hash and password_verify)

**Concepts Used**: Session, Auth and AJAX

**Database Name**: travel -> **Tables**: users, journals

**Features implemented in my task (Normal+Bonus)**:

1. Travel site has user login and registration page. Any user trying to access any files will be redirected to the login page.
2. A username while typing his preferred username is shown if the username is available or already taken using AJAX.
3. Passwords are hashed.
4. Repeated usernames are prevented using unique keyword and error is thrown if user tries to have an existing username.
5. Dashboard: Here the user is provided with a map where he/she can place a marker on to indicate the place that they have travelled to.
   a) User can mark a place and write a journal
   b) User can mark a place and see the journals around
6. Only public journals are displayed.
7. Users can view the journals written by them in your journals section. Here they can view their private journals.
8. Images can be added to the journal entry(Bonus)
9. Users can vote journals of other users. They can't vote for their own journals. Number of votes are displayed in each of the review.(Bonus)
10. Sorting options are provided based on the date of entry and number of votes(Bonus)
11. Multiple journal entries for same location is allowed for the same user if and only if the date of entries are different. Else, they're shown that you've already reviewed the location on the mentioned date.(Bonus)

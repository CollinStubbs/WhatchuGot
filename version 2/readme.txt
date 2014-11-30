To check this inside your laptop
1. Drop the whatchugot database from your mysql
2. import the whatchugot.sql script
3. add a password for your php admin for root or
	add a new user and password for your php admin and once you do that go to cred.php and change the username and password. For now the username is root and password is 201274

Here is what I have done so far.
1. register a new user works. (register.php)
   Password encription is also done
2. User authentication also works.(check accessing AdminMessage.php from browser to test)
   if you want a page to open only by Admin at the very top of the page you add
	<?php require_once("session.php"); ?>
	<?php require("func.php"); ?>
	<?php check_logged_in_admin(); ?>
   if you want a page to open only by Admin and Student add at the very top of the page
  	<?php require_once("session.php"); ?>
	<?php require_once("func.php"); ?>
	<?php check_logged_in_student(); ?>
3. Sending a message through the contact page is also done


ToDo
1. Style the pages using bootstrap (I tried doing it but it didn't work for me. So what I have been doing is creating a form in a new page and using that. I tried copying the exact form and pasting it inside the body of a bootstarp page and it didn't work for me. This specifically seems to not work when the form has a submit button. Somehow triggering an action with a submit button inside bootstrap doesn't work.

2. I am going to create a dashboard for both admin and student. Depening on account type the user will be redirected to the appropriate dashboard
3. Create a form for sending message
4. Display the post
5. Enable Edit & Delete features for messages, posts
6. Implement twitter


	
   

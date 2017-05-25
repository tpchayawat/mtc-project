# MTC E-Testing Platform Project
This is our OpenSource Project to "cure" TH Education due to Thailand 4.0, so it's for non-commercial use only.
The Item bank is used for collecting and keep the tests, which are changed from paper based to digital based for manage easier. 
All of tests from the itembank can be analyzed quality of test which conduct to the analyzing quality of examinee or students.
There are parameter to detemine the difficulty of item, which can seperate kind of student, which these data can be analyzed to improve them at the exactly weak point.
So, we need to be a part of the future to build the new quality of TH education better and better.

```
BETA Version is NOW
```

## Main Features
* For Instructors
  * Manage item bank and forms
  * Automatic import items from "csv" file
  * Manual create forms for quiz
  * Open quiz for students
  * View report of course
  * View report of students
* For Students
  * Take quiz
  * View summary result
* For Admin
  * Manage user and assign role
  * Manage course

## The platfrom is compatible with?
* Study "Itembank" template for Beginner Developers
* Implementation for school or tutor's centors
* AND FOR NON-COMMERCIAL USE ONLY

# Get Started
All web interface from this project has been developing using PHP and Javascript mainly.
If You're EXPERT in these field, PLEASE DO NOT EXPECT from this project. There are so many bugs and we try to fix these.
We are building this project for offline perposed. So, it's not safe to deploy on cloud computing.
Finally, This project is BETA version. If there are PROBLEMs or SOME BUGs, Please report an issues

## Prerequisites
### Software Requirement (Windows OS)
* XAMPP
  * Apache2 WebServer
  * MySQL Server
  * PHP5 (or above)
* Java RE 8

## How to Setup
### First
Please intall softwares or dependencies from "Software Requirement"
and MAKE SURE that you've already installed all of these
### Second - Setup Web Interface
[For XAMPP]
1. Create "mtc-project" folder into directory "c:/xampp/htdocs" (for XAMPP)
2. Download zip form github, then unzip into "mtc-project" directory
3. Move folder "assets" and all file in "web-interface" to "mtc-project" folder
### Third - Setup Database
1. Create database named "mtc-project" or something what you want
2. Import "mtc-project.sql" structure into created database
3. Add database name and mysql data (user and password) in "mtc-project/include/connect_db.php"
Note: You need to MANUAL ADD admin's user into database directly

# About MTC E-Testing
## Main Components
* jQuery
* Bootstrap3
* Font-Awesome
* NVD3 (D3.js integrated)
* PHPWord

# Authors
MTC E-Testing Platform is developed by Chayawat Pechwises
Email: tp.chayawat@gmail.com
VasabiLab at Computer Science Departement
Thammasat University

# Acknowledgement
* Computer Science at Thammasat University
* Digital Economy Promotion Agency (DEPA)
* Research Gap Fund - NSTDA

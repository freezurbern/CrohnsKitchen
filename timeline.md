# Crohn's Kitchen Timeline
##### Order in which code needs to be written

#### 1. Environment
- [X] error-handler.php
- [X] email-handler.php

#### 2. SQL Objects
- [X] Database Object
- [X] Insert Food Method
- [X] Insert Rating Method
- [X] Create / Set User Data Method (email, passhash)
- [X] Query User Data Method (id, email, passhash, create date)
- [X] Add Verify Key Method
- [X] Check Verify Key Method
- [X] Remove Verify Key Method
- [X] List Foods Method
- [X] List Ratings Method
- [X] List Users Method
- [X] Login Check Method

#### 4. Sessions
- [X] Session Start
- [X] Destroy
- [X] Store username
- [ ] Check for username and permission
- [X] Set user ID for db lookup

#### 5. Data Visualization
- [X] Tables: http://datatables.net/manual/styling/bootstrap
- [ ] Charts: Chart.js ??
- [ ] Dashboard
- [X] Data Page

#### 6. Pages
- [X] Login
- [X] Register
- [ ] Forgot Password
- [ ] Change Email / Password
- [ ] Create multiple foods: upload .csv?
- [X] Create rating
- [ ] User Dashboard
- [ ] Delete Account

#### 7. Admin
- [X] Disallow registrations
- [ ] Allow admin approved registrations
- [ ] Remove accounts
- [ ] masquerade as account
- [ ] logging table (IP, datetime, event, page)
- [ ] maintenance mode
- [ ] maintenance page
- [ ] food approval for all users
- [ ] move approved foods to admin user ID
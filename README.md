# Common git commands
| Commands                       | Description                                                                                                  |
|--------------------------------|--------------------------------------------------------------------------------------------------------------|
| `git clone repo-url` | Download the codebase to your local machine                                                                  |
| `git pull`                     | Update the current branch with the latest changes                                                            |
| `git checkout branch-name`     | Swap to a branch called "branch-name"                                                                        |
| `git checkout -b branch1`      | Create a new branch called "branch1" using the existing code from the current branch, and swap to "branch1" |
| `git commit -m "hello"`        | Create a snapshot of your changes (ie. a commit) with a description, "hello"                                 |
| `git push`                     | Upload commits to the online repository                                                                      |
| `git reset --soft HEAD~1`      | Undo last commit and keep the changes                                                                        |
| `git reset --hard`             | Undo last commit and discard the changes                                                                     |

# Table of Content
### First time setup (one time)
  - [Clone the repository](first-time-setup)
  - [Install packages](first-time-setup)
  - [Check for environmental variables](first-time-setup)
### Developing a ticket
- Before coding
  - [Assign yourself to the ticket](#1-assign-yourself-to-the-ticket)
  - [Create a new branch for your code](#2-create-a-new-branch-for-your-code)
- While coding
  - [Stage your changes](#3-stage-your-changes)
  - [Commit your changes](#4-commit-your-changes)
  - [Undoing your commits (Optional)](#5-undoing-your-commits-optional)
- After coding
  - [Merge your branch with changes from `main`](#6-merge-your-branch-with-changes-from-main)
  - [Resolve merge conflicts](#7-resolve-merge-conflicts)
  - [Push your changes](#8-push-your-code)
  - [Create a PR (pull request)](#9-create-a-pr-pull-request)
  - [Notify people](#10-notify-people)

# First time setup
```
git clone https://github.com/Baavi/SepB.git
```

# Flow of developing a ticket
## Before coding
### 1. Assign yourself to the ticket
- Drag the ticket you're planning to work on to the `Doing` column. The Trello board will automatically assign you to the ticket when you do it.

### 2. Create a new branch for your code
```
git checkout main
git pull
git checkout -b 01-ticket-name
```
Explanation:
- Swap to `main` branch
- Update your `main` branch with the latest changes
- Create a new branch using existing code from `main` and swap to it. Branch naming convention is `ticketnumber-ticket-name`

## While coding
It's recommended that you either regularly commit your code, or do small consecutive commits at the end when you've finished developing your feature, instead of including everything in 1 big commit. This is because if something goes wrong, big commits are harder to revert since you may not want to revert all of your changes. 

### 3. Stage your changes
![](./docs/staging-code.png)

a. Go to the "Source Control" tab in VSCode

b. Choose what you'd like to commit by clicking the `+` button next to the files. You can also choose all files by hovering over "Changes" and clicking the `+` button next to it instead)

### 4. Commit your changes
```
git commit -m "feat(feature-name): what you did"
```
There are 3 types of commits you can do. Depending on the type of commits you make you'll need to include a different prefix for your commit message:
- Adding a new feature: `feat`
- Making a fix/improvement: `fix`
- Writing documentations: `doc`

### 5. Undoing your commits (Optional)
```
git reset --soft HEAD~1
```
Run this command if you'd like to undo your last commit. You can repeatedly execute this to continue reverting back (Note that the previous reverted changes will pile up on top of the next reverted changes).

## After coding

### 6. Merge your branch with changes from `main`
We do this to make sure that our branch is always compatible with `main` to be merged in. Make sure you've committed everything you needed before you do this.
```
git checkout main
git pull
git checkout 01-your-branch
git merge main
```
Explanation:
- Swap to `main` branch
- Update your `main` branch with the latest changes
- Swap back to your feature branch
- Merge changes from `main` branch into your feature branch

### 7. Resolve merge conflicts
Scenario: You've executed `git merge main`, now you're seeing this in vscode: 
```
<<<<<<< HEAD
// Code A
=======
// Code B
>>>>>>> main
```
This means you're having a merge conflict:
- The code between `<<<<<<< HEAD` and `=======` is the code in your current branch
- The code between `=======` and `>>>>>>> main` is the code from the `main` branch

These 2 blocks of code are competing for the same spot. And you'll need to resolve this before you can commit your code.
- If you only want changes from your branch, delete everything except `// Code A`
- If you only want changes from `main`, delete everything except `// Code B`
- If you want both changes, delete the symbols (`<<<<<<< HEAD`, `=======` and `>>>>>>> main`). Same thing for if you want bits from this and bits from that

### 8. Push your code
```
git push
```
If you're pushing for the first time in a new branch, you will get something like this. Just copy paste the one shown in your terminal and press Enter to run it instead.
```
git push --set-upstream origin your-branch-name
```

### 9. Create a PR (Pull Request)
- Visit the GitHub repo page
- Start a PR by either pressing `Compare & Pull Request` (will only be visible if you've *just* pushed your changes), or if the button is not available you can click on Pull Request > New Pull Request. Both methods will take you to the same screen
- Conventions:
  - The base should always be `main`.
  - PR name should be the same as `ticketnumber - Ticket Name`
  - Message should have a short change summary of what you've done

### 10. Notify people
- Move ticket over to Pull Request column
- Send a message in discord

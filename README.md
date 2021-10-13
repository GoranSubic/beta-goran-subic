# beta-goran-subic
Excercise tasks for Goran Subic

# Task #1 - Node Goto

Description
- Create a custom "Node Goto" titled module.
The module will provide a custom block which will display a number type field, named "Node ID" and a "Go" titled submit button below it. When the block is enabled in some region of some page, users can fill out the Node ID field with a number and then clicking on the "Go" button will redirect them to the given node if a node with that actual ID is available. If no node can be found for the provided ID, then an appropriate error message should be displayed in the block which informs the user about the error.

Major requirements

- The module title should be "Node Goto" with a machine name "node_goto"
- The module should define an own permission and the block should be only available for those users who have that special permission
- The codebase should follow the Drupal coding standards
- Notes: 
The above description is intentionally brief, and you might have some questions regarding some details but that's fine. I would like to see how you can handle this task based on the above description only, and how you "fill out the gaps" and solve the problems. Feel free to read any documentation or article which might help but please work on your own.


# Task #2 - Password Policy

Description
- Create a custom "Password Policy" titled module.

- The task is to write a simpler password policy module which can be used to alter the default Drupal password requirements (there are no requirements, just recommendations). The way the module should work is that when a user wants to change his password through the edit profile page, the module should validate the password and only allow to save the settings if the password meets with the configured requirements.

- The module should have a configuration page under the "admin/config/people" path with an own "Password Policy" titled menu item. The configuration page should provide 5 checkboxes for 5 different password policy rules which can be enabled individually in any combination. The available configuration options should be the following in this order:

- The password must be at least 8 characters long.
The password must include at least one digit (0-9).
The password must include at least one lower cased letter.
The password must include at least one upper cased letter.
The password must include at least one special character.
- The default configuration (when the module is freshly installed) should be the 8 characters long option (first checkbox). So when for example the 1st and 4th options are enabled on the configuration page, the module should only allow to save passwords when all the below requirements are met:

- The password is at least 8 characters long.
The password contains at least one upper cased letter.
As another example, when the 2nd, 3rd and 5th options are enabled on the configuration page, the module should only allow to save passwords when all the below requirements are met:

- The password contains at least one digit.
The password contains at least one lower cased letter.
The password contains at least one special character.

Major requirements

- The module title should be "Password Policy" with a machine name "password_policy"
- The module's configuration page should be only available for administrators
- When possible please use regular expressions for the different password requirement checks.
- The module should display the list of the currently enabled password requirements on the user profile edit page below the password field (as a help description for the user).
- The codebase syntax should follow our "company standards" I mentioned during the #3 task. So please use strict type declaration, final classes, parameter an return type declarations, annotations, function and method descriptions, etc. I mentioned before.
- There is no need for any frontend work (custom theming, template files, etc.).
- There is no need to deal with already existing or saved passwords, so the module should only validate the password changes through the user profile edit form.
- There is no need to deal with the built in "Reset password" functionality (/user/password).
- Notes: 
The above description is intentionally brief, and you might have some questions regarding some details but that's fine. I would like to see how you can handle this task based on the above description only, and how you "fill out the gaps" and solve the problems. Feel free to read any documentation or article which might help but please work on your own.


# Task #3 - Coupon Codes

Description
- Create a custom "My coupons" titled module.

- The module should provide a "My coupons" titled page which is only available for logged in (authenticated) users. The "My coupons" page is a listing page, it lists all the coupons the currently logged in user has access to. Coupons are represented by a custom "Coupon" named content type, which has the following fields (next to other default properties Drupal adds to new content types):

- Code: It’s a single value “Text (plain)” type field which is required and has no default value.
Description: It's a single value "Text (formatted, long)" type field which is not required and has no default value.
User access: It's a multi value Entity Reference type field for User entities which is not required and has no default value.
- Coupon nodes can be managed (create, update or deleted) only by administrators. Regular authenticated users can only have view access to a Coupon node when the node is published AND their account is referenced in the "User access" entity reference field. So only view access can be granted through the "User access" field unless a referenced user doesn't have administrator rights. When the “User access” field is empty, only administrators have access to the node regardless of the published state. According to these, the "My coupons" page should list only those coupons which are published and where the currently logged in user is referenced in the "User access" field. The coupon list should display the coupon title as a link to the actual node and the coupon code below it.

- The "My coupons" page should be reachable through a "My coupons" titled tab next to the View and Edit tabs on the user profile page.

- Please pay extra attention, because users should not have access to each other's coupon in any circumstances.

Requirements

- The module title should be "My coupons" with a machine name "my_coupons".
- If necessary, you can depend on any other module which might help to fulfill the requirements in the task description, but please encapsulate everything (even the necessary configuration objects) in the "my_coupons" module.
- The codebase syntax should follow our "company standards" I mentioned during the previous tasks (Task #1 - Node Goto, Task #2 - Password Policy). So when possible please use strict type declaration, parameter and return type declarations, final classes, annotations, function and method descriptions, etc.
- Notes: 
The task description is intentionally brief, and you might have some questions regarding some details but that's fine. I would like to see how you can handle this task based on the above description only, and how you "fill out the gaps" and solve the problems. Feel free to read any documentation or article which might help but please work on your own.

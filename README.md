# NUKI example application

This is an example application using the NUKI framework.
With this example you can: registrate, login and change user settings.

#Setup
- clone the repository and make sure the name of your folder is "nukilogin"
    - if you'd like a different name, you must modify the path in the "settings/Rendering/rendering/json" file
- modify the database credentials inside "settings/Database/connection-pdo.json"
- do "composer install"  with "--no-dev" to skip dev requirements   

#Structure
- **Units:**
    - **System**
        - **Services**:
            - Registration
            - Login
            - Save settings
        - **Extenders**
            - RegisterTerminateWatchers (to attach your own custom watchers to the framework event: TerminateApplication)
            - SetCsrfTokens
            - RegisterAuthExtender
            - RedirectIfLoggedInExtender
            - CheckCsrf
        - **Events**
        - **Watchers**

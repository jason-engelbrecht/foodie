# foodie
foodie, recipe sharing space

Project Requirements:
  Separates all database/business logic using the MVC pattern.
    - All business logic is seperated following the MVC pattern.
  Routes all URLs and leverages a templating language using the Fat-Free framework.
    - All URLS are routed to views using fat-free
  Has a clearly defined database layer using PDO and prepared statements.
    - All data interactions are defined in model.
  Data can be viewed, added, updated, and deleted.
    - Recipes can be viewed, shared, updated, and deleted.
  Has a history of commits from both team members to a Git repository.
    - Commits are in github.
  Uses OOP, and defines multiple classes, including at least one inheritance relationship.
    - Yes, we have a recipe class and two children classes (metric recipe and standard recipe)
  Contains full Docblocks for all PHP files and follows PEAR standards.
    - All PHP files are fully documented.
  Has full validation on the client side and server side through PHP.
    - Validates input with php and requires input with HTML.
  BONUS:  Incorporates Ajax that access data from a JSON file, PHP script, or API. If you implement Ajax, be sure to talk about it in your presentation.
    - Search functionality created with ajax.

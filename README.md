Projet : Gestion d’utilisateurs en PHP avec classes et formulaires

Dans ce projet, j’ai appris à créer et utiliser des classes en PHP pour gérer des utilisateurs avec une base de données MySQL. L’objectif était de mettre en place un CRUD utilisateur et de travailler à la fois avec MySQLi puis avec PDO.

J’ai d’abord créé une base de données appelée “classes” avec une table “utilisateurs” contenant les champs id, login, password, email, firstname et lastname.

Ensuite, j’ai créé deux classes différentes :
une classe User qui utilise MySQLi et une classe Userpdo qui utilise PDO avec des requêtes préparées.
Ces classes permettent d’inscrire un utilisateur, le connecter, mettre à jour ses informations, le supprimer et récupérer ses informations.

Comme en cours nous avons surtout travaillé avec des formulaires, j’ai aussi créé des pages PHP avec des formulaires pour tester ces méthodes de manière plus concrète.
Par exemple, j’ai une page d’inscription pour créer un utilisateur et une page de connexion pour vérifier l’authentification. Ces formulaires appellent les méthodes de la classe Userpdo.

J’ai également ajouté un peu de CSS très simple pour rendre les formulaires plus agréables visuellement.

Ce projet m’a permis de mieux comprendre la programmation orientée objet en PHP, l’utilisation d’une base MySQL, ainsi que la différence entre MySQLi et PDO. J’ai aussi pratiqué la structure d’un projet PHP avec plusieurs fichiers séparés (classes, formulaires, etc.) et l’échange de données entre le code et la base.

# Laetitia Deschamps
[![forthebadge](https://img.shields.io/badge/LinkedIn-0077B5?style=for-the-badge&logo=linkedin&logoColor=white)](https://www.linkedin.com/in/laetitiadeschamps/)  [!

## Stack 
[![forthebadge](https://img.shields.io/badge/Symfony-000000?style=for-the-badge&logo=Symfony&logoColor=white)](http://forthebadge.com)
[![forthebadge](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)](http://forthebadge.com)
[![forthebadge](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5&logoColor=white)](http://forthebadge.com)
[![forthebadge](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3&logoColor=white)](http://forthebadge.com)
[![forthebadge](https://img.shields.io/badge/json-5E5C5C?style=for-the-badge&logo=json&logoColor=white)](http://forthebadge.com)
[![forthebadge](https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white)](http://forthebadge.com)
[![forthebadge](https://img.shields.io/badge/Bootstrap-563D7C?style=for-the-badge&logo=bootstrap&logoColor=white)](http://forthebadge.com)
[![forthebadge](https://img.shields.io/badge/Git-F05032?style=for-the-badge&logo=git&logoColor=white)](http://forthebadge.com)
[![forthebadge](https://img.shields.io/badge/Insomnia-5849be?style=for-the-badge&logo=Insomnia&logoColor=white)](http://forthebadge.com)
### Description

Ce projet est une API REST d'ingrédients de cuisine, créée avec API Platform et une pipeline d'intégration continue sur GitLab.
Documentation OpenApi/Swagger. Voici un aperçu des fonctionalités : 

### Ingrédients

- GET: /api/ingredients : renvoie la liste des ingrédients, leur catégorie, slug, url de l'image.
Filtres : par nom (nom contenant la chaine de caractère saisie), par id (possibilité de renseigner plusieurs id)
Tri : par ordre ASC / DESC de nom et/ou d'id
Pagination : par défaut, 100 résultats par page, possibilité de modifier ce nombre en paramètre d'url. Par défaut, affiche la page 1, possibilité de modifier la page en paramètre d'url. Les informations hydra issues du format ld+json renvoient, pour chaque requête, la page précédente et la page suivante, s'il y en a.
- GET : /api/ingredients/{id} : renvoie l'ingrédient demandé
- POST : /api/ingredients : permet la création d'un ingrédient. Nécessite un objet JSON avec une clé "name". Renvoie l'objet créé, avec son IRI.
- PUT/PATCH :  /api/ingredients/{id} : permet la modification d'un ingrédient. Nécessite un objet JSON avec une clé "name". Renvoie l'objet modifié, avec son IRI.
- DELETE : /api/ingredients/{id} : permet la suppression d'un ingrédient. 
- POST : /api/ingredients/{id}/image : permet l'upload d'une image et son association avec l'ingrédient demandé. Renvoie l'objet créé, avec le chemin vers l'image et son IRI.

### Catégories     

- GET : /api/categories : renvoie la liste des categories, slug, url de l'image.
Filtres : par nom (nom contenant la chaine de caractère saisie), par id (possibilité de renseigner plusieurs id)
Tri : par ordre ASC / DESC de nom et/ou d'id
Pagination: pas de pagination
- GET : /api/categories/{id} : renvoie la categorie demandée, avec un objet ingredients, contenant une collection d'instances de la classe ingrédients appartenant à cette catégorie
- POST : /api/categories : permet la création d'une catégorie. Nécessite un objet JSON avec une clé "name". Renvoie l'objet créé, avec son IRI.
- PUT/PATCH :  /api/categories/{id} : permet la modification d'une catégorie. Nécessite un objet JSON avec une clé "name". Renvoie l'objet modifié, avec son IRI.
- DELETE : /api/categories/{id} : permet la suppression d'une catégorie. 
- POST : /api/categories/{id}/image : permet l'upload d'une image et son association avec la catégorie demandée. Renvoie l'objet créé, avec le chemin vers l'image et son IRI.








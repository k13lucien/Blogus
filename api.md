Authentification

****************************************************

POST /api/register

Body Json {
    "name": "John",
    "email": "JOhn@email.com",
    "password": "********"
}

Response Json {
    "message": "Utilisateur créé",
    "user": {
        "name": "John",
        "email": "JOhn@email.com",
        "updated_at": "2025-08-18T12:43:01.000000Z",
        "created_at": "2025-08-18T12:43:01.000000Z",
        "id": 6
    }
}
****************************************************

POST /api/login

Body Json {
    "email": "JOhn@email.com",
    "password": "********"
}

Response Json {
    "message": "Connexion réussie",
    "token": "9|1XFY5SJHuR4cOkm3rQpKhGkFbkCCBYw2o1OrEjTF7ca40ad4",
    "token_type": "Bearer",
    "user": {
        "id": 6,
        "name": "John",
        "email": "JOhn@email.com",
        "email_verified_at": null,
        "created_at": "2025-08-18T12:43:01.000000Z",
        "updated_at": "2025-08-18T12:43:01.000000Z"
    }
}
*****************************************************

GET /api/user

Response Json {
    "id": 6,
    "name": "John",
    "email": "JOhn@email.com",
    "email_verified_at": null,
    "created_at": "2025-08-18T12:43:01.000000Z",
    "updated_at": "2025-08-18T12:43:01.000000Z"
}
*****************************************************

POST /api/logout

Response Json {
    "message": "Déconnecté (Token revoqué)"
}
*****************************************************



Ressources

* articles

GET /api/article

POST /api/article

GET /api/article/{id}

PUT /api/article/{id}

DELETE /api/article/{id}

* comments

GET /api/comment

POST /api/comment

GET /api/comment/{id}

PUT /api/comment/{id}

DELETE /api/comment/{id}

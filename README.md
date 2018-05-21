# Escuelas 

### GET /escuelas
+ Response 200 
```json
    [
        {
            "id_escuela":"",
            "escuela":"",
            "matricula":""
        }
    ]
```

### POST /usuarios/registrar
+ Body 
```json
    {
        "nombre": "Luis ",
        "apellidos": "Escobedo Trenado",
        "correo": "escobedi@correo.com",
        "pass": "esc0bed0",
        "id_escuela": "1",
        "id_carrera": "1",
        "id_grado": "6"
    }
```
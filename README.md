<br/>

![Laravel](https://img.shields.io/badge/Laravel-11.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Livewire](https://img.shields.io/badge/Livewire-3.x-FB70A9?style=for-the-badge&logo=livewire&logoColor=white)
![Tailwind](https://img.shields.io/badge/Tailwind_CSS-3.x-06B6D4?style=for-the-badge&logo=tailwindcss&logoColor=white)
![AlpineJS](https://img.shields.io/badge/Alpine.js-8BC0D0?style=for-the-badge&logo=alpinedotjs&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)

<br/>

[![Licencia](https://img.shields.io/badge/Licencia-Uso_Privado-red?style=flat-square)](LICENSE)
[![Estado](https://img.shields.io/badge/Estado-En%20Desarrollo-1e40af?style=flat-square)]()

Foro comunitario interactivo diseñado para alumnos, docentes y administrativos del **Tecnológico Superior de Jalisco, Campus Lagos de Moreno**.

> *"Conectando el ingenio del Tec."*

</div>

---

## ¿Qué es TecNow?

**TecNow** es una plataforma inspirada en el modelo de Reddit, optimizada para el entorno académico. Resuelve el problema de la comunicación dispersa centralizando hilos de discusión, avisos oficiales y recursos educativos en un entorno seguro y categorizado.

- **Comunidades (Sub-Tecs):** Canales específicos para ISC, Industrial, Gestión, etc.
- **Sistema de Karma:** Recompensa a los usuarios que aportan soluciones reales.
- **Votaciones Polimórficas:** Upvotes y Downvotes en posts y comentarios para destacar lo mejor.
- **Media Support:** Compartir capturas de errores de código, diagramas y videos de proyectos.

---

## Estructura del Proyecto (Stack TALL)

```bash
TecNow/
├── app/
│   ├── Livewire/              # Componentes interactivos (Votos, Comentarios)
│   ├── Models/                # Relaciones Polimórficas (Votos, Multimedia)
│   └── Providers/
├── resources/
│   ├── views/
│   │   ├── components/        # UI Reutilizable con Blade y Tailwind
│   │   ├── livewire/          # Templates de componentes en tiempo real
│   │   └── layouts/           # App y Guest layouts
├── database/
│   ├── migrations/            # Estructura jerárquica de comentarios y posts
│   └── seeders/               # Datos de prueba para el Tec
├── public/
├── routes/
│   └── web.php                # Rutas del foro y perfiles
└── README.md
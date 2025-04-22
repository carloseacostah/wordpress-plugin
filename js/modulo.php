
<div class="modulo">
  <h2 class="modulo__titulo">Este es el título del módulo</h2>
  <p class="modulo__descripcion">Este es un texto descriptivo del módulo. diseño de Figma.</p>
  <button class="modulo__boton">Haz clic aquí</button>
</div>

/* Archivo SCSS: scss/_variables.scss */
$color-primary: #1a73e8;
$color-secondary: #e8f0fe;
$color-text: #202124;

/* Archivo SCSS: scss/main.scss */
@import 'variables';

.modulo {
  background-color: $color-secondary;
  padding: 20px;
  border-radius: 10px;
  text-align: center;

  &__titulo {
    color: $color-primary;
    font-size: 24px;
  }

  &__descripcion {
    color: $color-text;
    margin: 10px 0;
  }

  &__boton {
    background-color: $color-primary;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;

    &:hover {
      background-color: darken($color-primary, 10%);
    }
  }

  @media (max-width: 768px) {
    padding: 10px;
    &__titulo {
      font-size: 20px;
    }
  }
}


/* bloque Gutenberg*/
const { registerBlockType } = wp.blocks;
const { createElement } = wp.element;

registerBlockType('modulo/bloque', {
  title: 'Módulo Personalizado',
  icon: 'admin-site',
  category: 'widgets',
  edit: () => createElement('p', {}, 'Bloque de ejemplo del módulo'),
  save: () => null, // Se renderiza desde PHP
});


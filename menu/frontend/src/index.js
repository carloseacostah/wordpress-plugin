import './style.scss';
import { registerBlockType } from '@wordpress/blocks';
import { SelectControl } from '@wordpress/components';
import { useBlockProps, InspectorControls, PanelBody } from '@wordpress/block-editor';
import { __ } from '@wordpress/i18n';
import apiFetch from '@wordpress/api-fetch';
import { useState, useEffect } from '@wordpress/element';

import './editor.scss'; // Estilos específicos para el editor


registerBlockType('mi-prueba-tecnica/menu', {
    title: __('Mi Prueba Técnica Menu', 'mi-prueba-tecnica'),
    description: __('Muestra un menú de WordPress seleccionado.', 'mi-prueba-tecnica'),
    category: 'widgets',
    icon: 'menu',
    supports: {
        align: true,
    },
    attributes: {
        selectedMenu: {
            type: 'string',
            default: '',
        },
    },
    edit: (props) => {
        const { attributes, setAttributes } = props;
        const { selectedMenu } = attributes;
        const blockProps = useBlockProps();
        const [menus, setMenus] = useState([]);
        const [loadingMenus, setLoadingMenus] = useState(true);

        useEffect(() => {
            apiFetch({ path: '/wp/v2/menus' })
                .then((response) => {
                    const menuOptions = response.map((menu) => ({
                        label: menu.name,
                        value: menu.id.toString(),
                    }));
                    setMenus(menuOptions);
                    setLoadingMenus(false);
                })
                .catch((error) => {
                    console.error(__('Error fetching menus:', 'mi-prueba-tecnica'), error);
                    setLoadingMenus(false);
                });
        }, []);

        const onChangeMenu = (newMenu) => {
            setAttributes({ selectedMenu: newMenu });
        };

        return (
            <>
                <InspectorControls>
                    <PanelBody title={__('Opciones del Menú', 'mi-prueba-tecnica')}>
                        {loadingMenus ? (
                            <p>{__('Cargando menús...', 'mi-prueba-tecnica')}</p>
                        ) : (
                            <SelectControl
                                label={__('Seleccionar Menú', 'mi-prueba-tecnica')}
                                value={selectedMenu}
                                options={[{ label: __('Seleccionar un menú', 'mi-prueba-tecnica'), value: '' }, ...menus]}
                                onChange={onChangeMenu}
                            />
                        )}
                    </PanelBody>
                </InspectorControls>
                <div { ...blockProps }>
                    {selectedMenu ? (
                        <p>{__('Menú seleccionado:', 'mi-prueba-tecnica')} {menus.find(menu => menu.value === selectedMenu)?.label}</p>
                    ) : (
                        <p>{__('Por favor, selecciona un menú en las opciones del bloque.', 'mi-prueba-tecnica')}</p>
                    )}
                </div>
            </>
        );
    },
    save: (props) => {
        const blockProps = useBlockProps.save();
        return <div { ...blockProps }></div>;
    },
});

document.addEventListener('DOMContentLoaded', () => {
    const hasSubmenuItems = document.querySelectorAll('.main-navigation__item--has-submenu');

    hasSubmenuItems.forEach(item => {
        const link = item.querySelector('.main-navigation__link');
        const submenu = item.querySelector('.submenu');

        if (link && submenu) {
            item.addEventListener('mouseenter', () => {
                submenu.classList.add('is-open');
            });

            item.addEventListener('mouseleave', () => {
                submenu.classList.remove('is-open');
            });
        }
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const mainNavigation = document.querySelector('.main-navigation');
    const menuButton = document.createElement('button');
    menuButton.classList.add('main-navigation__menu-button');
    menuButton.setAttribute('aria-expanded', 'false');
    menuButton.setAttribute('aria-controls', 'main-navigation__list-mobile');
    menuButton.innerHTML = '<span>Menú</span>'; // Puedes usar un icono SVG aquí

    const navigationList = document.querySelector('.main-navigation__list');
    if (navigationList) {
        navigationList.id = 'main-navigation__list-mobile';
        mainNavigation.insertBefore(menuButton, navigationList);
        navigationList.classList.add('main-navigation__list--mobile');
    }

    menuButton.addEventListener('click', function() {
        const expanded = this.getAttribute('aria-expanded') === 'true' || false;
        this.setAttribute('aria-expanded', !expanded);
        navigationList.classList.toggle('is-open');
    });

    const mainNavItemsWithSubmenu = document.querySelectorAll('.main-navigation__item--has-submenu');
    const globalSubmenuContainer = document.querySelector('.global-submenu-container');

    mainNavItemsWithSubmenu.forEach(item => {
        // ... (Tu código JavaScript existente para el hover del submenú global) ...
        const link = item.querySelector('.main-navigation__link');
        if (link) {
            link.addEventListener('click', function(event) {
                if (window.innerWidth < 768 && item.classList.contains('main-navigation__item--has-submenu')) {
                    event.preventDefault();
                    item.classList.toggle('submenu-mobile-open');
                    const submenu = item.querySelector('.submenu');
                    if (submenu) {
                        submenu.style.display = submenu.style.display === 'block' ? 'none' : 'block';
                    }
                }
            });
        }
    });
 
});

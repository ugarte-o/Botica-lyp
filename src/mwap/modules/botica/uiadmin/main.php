<?php

class mwap_botica_uiadmin_main
    extends mwmod_mw_ui2_def_main_admin
{
    function __construct($ap)
    {
        $this->set_mainap($ap);

        /*
         * Pantalla inicial del administrador.
         */
        $this->subinterface_def_code =
            "welcome";

        /*
         * Ruta principal del panel.
         */
        $this->url_base_path =
            "/admin/";

        /*
         * Obliga a tener una sesión iniciada.
         */
        $this->enable_session_check();

        /*
         * Archivo utilizado para cerrar sesión.
         */
        $this->logout_script_file =
            "logout.php";

        /*
         * Opciones principales del menú lateral.
         *
         * Botica contiene:
         * - Pedidos
         * - Cobranza
         * - Inventario
         * - Agregar producto
         * - Reportes
         */
        $this->su_cods_for_side =
            "botica,mwx,users,cfg";
    }

    function create_template()
    {
        return new mwtheme_default_mainuitemplate(
            $this
        );
    }

    function createUISessionDataMan()
    {
        return new mwmod_mw_data_session_man(
            "boticamainui"
        );
    }


    function create_subinterface_botica()
    {
        return new mwap_botica_uiadmin(
            "botica",
            $this
        );
    }

  
    function create_subinterface_welcome()
   {
    return new mwap_botica_uiadmin_welcome(
        "welcome",
        $this
        );
   }

    /*
     * Conserva Meralda X cuando esté disponible.
     */
    function create_subinterface_mwx()
    {
        $autoload =
            mw_get_autoload_manager();

        if (
            $autoload->class_exists(
                "mwmod_mwx_demo_ui"
            )
        ) {
            return new mwmod_mwx_demo_ui(
                "mwx",
                $this
            );
        }

        return false;
    }
}
<?php

class mwap_botica_uiadmin
    extends mwmod_mw_ui_base_basesubuia
{
    function __construct($cod, $parent)
    {
        $this->init_as_main_or_sub($cod, $parent);
        $this->set_lngmsgsmancod("botica");
        $this->set_def_title("Botica LyP");

        $this->sucods =
            "pedidos,cobranza,inventario,agregarproducto,reportes";

        $this->subinterface_def_code = "pedidos";
    }

    function allowcreatesubinterfacechildbycode()
    {
        return true;
    }

    function _do_create_subinterface_child_pedidos($cod)
    {
        return new mwap_botica_pedidos_uiadmin_pedidos(
            $cod,
            $this
        );
    }

    function _do_create_subinterface_child_cobranza($cod)
    {
        return new mwap_botica_cobranza_uiadmin_inicio(
            $cod,
            $this
        );
    }

    function _do_create_subinterface_child_inventario($cod)
    {
        return new mwap_botica_inventario_uiadmin_inicio(
            $cod,
            $this
        );
    }

    function _do_create_subinterface_child_agregarproducto($cod)
    {
        return new mwap_botica_productos_uiadmin_inicio(
            $cod,
            $this
        );
    }

    function _do_create_subinterface_child_reportes($cod)
    {
        return new mwap_botica_reportes_uiadmin_inicio(
            $cod,
            $this
        );
    }

    function create_sub_interface_mnu_for_sub_interface(
        $su = false
    ) {
        return false;
    }

    function is_responsable_for_sub_interface_mnu()
    {
        return false;
    }

    function add_2_side_mnu($mnu, $checkallowed = true)
    {
        if (!$mnu) {
            return false;
        }

        if (
            $checkallowed &&
            !$this->is_allowed_on_mnu()
        ) {
            return false;
        }

        $iconos = [
            "pedidos" =>
                "meralda-icon-color meralda-icon-pedidos",

            "cobranza" =>
                "meralda-icon-color meralda-icon-cobranza",

            "inventario" =>
                "meralda-icon-color meralda-icon-inventario",

            "agregarproducto" =>
                "meralda-icon-color meralda-icon-agregarproducto",

            "reportes" =>
                "fas fa-chart-line mnuicon"
        ];

        $subinterfaces =
            $this->get_subinterfaces_by_code(
                $this->sucods,
                $checkallowed
            );

        if (!$subinterfaces) {
            return false;
        }

        foreach (
            $subinterfaces as
            $codigo => $subinterface
        ) {
            if (isset($iconos[$codigo])) {
                $subinterface->mnuIconClass =
                    $iconos[$codigo];
            }

            $subinterface->add_2_side_mnu(
                $mnu,
                $checkallowed
            );
        }

        return true;
    }

    function do_exec_no_sub_interface()
    {
    }

    function is_allowed()
    {
        return $this->allow("admin");
    }
}
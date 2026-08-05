<?php

/**
 * Gestor principal de la lógica de negocio de Botica.
 *
 * Los managers se cargan solamente cuando se utilizan.
 *
 * @property-read mwap_botica_pedidos_man $pedidos
 * @property-read mwap_botica_cobranza_man $cobranza
 * @property-read mwap_botica_inventario_man $inventario
 * @property-read mwap_botica_productos_man $productos
 * @property-read mwap_botica_reportes_man $reportes
 */
abstract class mwap_botica_base_mainmanabs
    extends mwmod_mw_manager_baseman
{
    private $pedidos;
    private $cobranza;
    private $inventario;
    private $productos;
    private $reportes;

    function __construct($code, $ap)
    {
        $this->init($code, $ap);
    }

    final function __get_priv_pedidos()
    {
        if (!isset($this->pedidos)) {
            $this->pedidos =
                new mwap_botica_pedidos_man(
                    $this->mainap
                );
        }

        return $this->pedidos;
    }

    final function __get_priv_cobranza()
    {
        if (!isset($this->cobranza)) {
            $this->cobranza =
                new mwap_botica_cobranza_man(
                    $this->mainap
                );
        }

        return $this->cobranza;
    }

    final function __get_priv_inventario()
    {
        if (!isset($this->inventario)) {
            $this->inventario =
                new mwap_botica_inventario_man(
                    $this->mainap
                );
        }

        return $this->inventario;
    }

    final function __get_priv_productos()
    {
        if (!isset($this->productos)) {
            $this->productos =
                new mwap_botica_productos_man(
                    $this->mainap
                );
        }

        return $this->productos;
    }

    final function __get_priv_reportes()
    {
        if (!isset($this->reportes)) {
            $this->reportes =
                new mwap_botica_reportes_man(
                    $this->mainap
                );
        }

        return $this->reportes;
    }
}
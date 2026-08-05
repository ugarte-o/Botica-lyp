<?php

/**
 * Aplicación principal de Botica LyP.
 *
 * @property-read mwap_botica_mainman $mainMan
 */
class mwap_botica_ap
    extends mwmod_mw_ap_def2
{
    private $mainMan;

    function __construct()
    {
    }

    function create_submanager_uiadmin()
    {
        return new mwap_botica_uiadmin_main(
            $this
        );
    }

    /**
     * Registra el manager principal de Botica
     * como submanager de la aplicación.
     */
    function create_submanager_botica()
    {
        return new mwap_botica_mainman(
            "botica",
            $this
        );
    }

    /**
     * Carga mainMan únicamente cuando se necesita.
     */
    final function __get_priv_mainMan()
    {
        if (!isset($this->mainMan)) {
            $this->mainMan =
                $this->get_submanager(
                    "botica"
                );
        }

        return $this->mainMan;
    }
}
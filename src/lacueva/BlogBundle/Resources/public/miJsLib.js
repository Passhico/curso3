/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


/* global s, id */


/**
 * @description Cambia el título 
 * @argument {string} s El nuevo Título
 */
function CambiaTitulo(s) {
	this.document.title = s;
}

/** Printa s en id
 * 
 * @author Pascual Muñoz <pascual.munoz@pccomponentes.com>
 * @description Añade la cadena 's' a el HTML del nodo con el id 'id'"
 * @argument {string} s Cadena a pintar.
 * @argument {string} id El Id del DOM.
 * @returns {void} 
 */
function PrintaEn(id, s) {
	this.document.getElementById(id).innerHTML += s;
}

/**
 * @description  shortcut de 	PrintaEn("demo", s);
 * @return {void} 
 * @param {string} s La cadena a printear en el nodo con id "demo"
 */
function p(s) {
	PrintaEn("demo", s);
}

/**
 * Hace un clear en el nodo (id)
 * @param {string} id El id del nodo 
 * @return {void} 
 */
function clear(id) {
	this.document.getElementById(id).innerHTML = "";

}



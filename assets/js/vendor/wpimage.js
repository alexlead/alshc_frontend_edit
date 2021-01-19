/**
 *  Wordpress Image Tool for the Editor.js
 *  
 *  description: Module for including Wordpress image tools to EditorJs
 *  author: Alexander Lead
 *  Author URL: https://codepen.io/alexlead
 *  Module Github: https://github.com/alexlead/
 *  
 *  To developers:
 *  This plugin can be used with WP function  
 *  wp_enqueue_media ();
 *  Please add above function to be started before EditorJs start
 *  Please add below code to initialization array of EditorJs tools
 * 
 *  wpimage:  WPImage,
 *      
 */

class WPImage {

    static get toolbox() {
        // add icon button to Editor
        return {
            title: 'Image',
            icon: '<svg width="17" height="15" viewBox="0 0 336 276" xmlns="http://www.w3.org/2000/svg"><path d="M291 150V79c0-19-15-34-34-34H79c-19 0-34 15-34 34v42l67-44 81 72 56-29 42 30zm0 52l-43-30-56 30-81-67-66 39v23c0 19 15 34 34 34h178c17 0 31-13 34-29zM79 0h178c44 0 79 35 79 79v118c0 44-35 79-79 79H79c-44 0-79-35-79-79V79C0 35 35 0 79 0z"/></svg>'
        };
    }

    constructor({ data, config, api, readOnly }) {
        /**
         * Editor.js API
         */
        this.api = api;
        this.readOnly = readOnly;

        /**
         * When block is only constructing,
         * current block points to previous block.
         * So real block index will be +1 after rendering
         *
         * @todo place it at the `rendered` event hook to get real block index without +1;
         * @type {number}
         */
        this.blockIndex = this.api.blocks.getCurrentBlockIndex() + 1;

        /**
         * Styles
         */
        this.CSS = {
            baseClass: this.api.styles.block,
            loading: this.api.styles.loader,
            input: this.api.styles.input,
            settingsButton: this.api.styles.settingsButton,
            settingsButtonActive: this.api.styles.settingsButtonActive,

        };

        /**
         * Nodes cache
         */
        this.nodes = {
            wrapper: null,
            imageHolder: null,
            image: null,
            caption: null,
        };

        /**
         * Tool's initial data
         */
        this.data = {
            url: data.url || '',
            alt: data.alt || '',
        };
    }

    render() {

        // add element to new block
        const el = document.createElement('img');

        if (!(this.data.url.length > 0)) {
            // open Wordpress images library
            wp.media.editor.open();

            // get data from selected image
            wp.media.editor.send.attachment = function(props, attachment) {
                // set image url
                el.src = attachment.url;
                // if alt set then add alt to image
                if (attachment.alt) {
                    el.alt = attachment.alt;
                }

            };
        } else {
            el.src = this.data.url;
            el.alt = this.data.alt;
        }

        return el;

    }

    save(wpimageContent) {

        // prepare output block
        return {
            url: wpimageContent.src,
            alt: wpimageContent.alt,
        }
    }


}
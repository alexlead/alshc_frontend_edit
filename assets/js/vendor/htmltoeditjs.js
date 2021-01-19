/*  
 *  Prepared for EditorJS (https://editorjs.io/)
 *  module: String To Blocks
 *  description: Module get HTML text and prepare blocks for EditorJS
 *  author: Alexander Lead
 *  Author URL: https://codepen.io/alexlead
 *  Module Github: https://github.com/alexlead/
 */

// @get     string with html tags 
// @return  data obj prepared for 
let stringToBlocks = function(post) {
        // create element for adding text html 
        var l = document.createElement("div");
        // adding post data to the element
        l.innerHTML = post;
        // make array with children elements 
        let htmlData = l.children;
        // empty obj for prepared data
        let jData = {
            blocks: []
        };
        // adding blocks to jData obj
        for (let i = 0; i < htmlData.length; i++) {
            jData.blocks.push(tagsToObj[htmlData[i].tagName](htmlData[i]));
        }
        return jData;
    }
    // methods tags to blocks for EditorJS  
let tagsToObj = {
    H1: function(obj) {
        let data = {
            type: "header",
            data: {
                text: `${obj.innerHTML}`,
                level: 1
            }
        }
        return data;
    },
    H2: function(obj) {
        let data = {
            type: "header",
            data: {
                text: `${obj.innerHTML}`,
                level: 2
            }
        }
        return data;
    },
    H3: function(obj) {
        let data = {
            type: "header",
            data: {
                text: `${obj.innerHTML}`,
                level: 3
            }
        }
        return data;
    },
    H4: function(obj) {
        let data = {
            type: "header",
            data: {
                text: `${obj.innerHTML}`,
                level: 4
            }
        }
        return data;
    },
    H5: function(obj) {
        let data = {
            type: "header",
            data: {
                text: `${obj.innerHTML}`,
                level: 5
            }
        }
        return data;
    },
    H6: function(obj) {
        let data = {
            type: "header",
            data: {
                text: `${obj.innerHTML}`,
                level: 6
            }
        }
        return data;
    },
    P: function(obj) {
        let data = {
            type: "paragraph",
            data: {
                text: `${obj.innerHTML}`
            }
        }
        return data;
    },
    BR: function(obj) {
        let data = {
            type: "delimiter",
            data: {}
        }
        return data;
    },
    FIGURE: function(obj) {
        let data = {
            type: "quote",
            data: {
                text: `${obj.children[0].innerHTML}`,
                caption: `${obj.children[1].innerHTML}`,
                alignment: `left`
            }
        }
        return data;
    },
    IMG: function(obj) {
        let data = {
            type: "wpimage",
            data: {
                url: `${obj.src}`,
                alt: `${obj.alt}`
            }
        }
        return data;
    },
    UL: function(obj) {
        let li = obj.children;
        let arr = [];
        for (let i = 0; i < li.length; i++) {
            arr.push(li[i].innerHTML);
        }
        let data = {
            type: "list",
            data: {
                items: arr,
                style: "unordered"
            }
        }
        return data;
    },
    OL: function(obj) {
        let li = obj.children;
        let arr = [];
        for (let i = 0; i < li.length; i++) {
            arr.push(li[i].innerHTML);
        }

        let data = {
            type: "list",
            data: {
                items: arr,
                style: "ordered"
            }
        }
        return data;
    },

}
'use strict'

import { Controller } from '@hotwired/stimulus';

export default class extends Controller {
    static targets = [
        'container',
        'entry'
    ]

    static values = {
        allowAdd: Boolean,
        allowDelete: Boolean,
        buttonAdd: String,
        buttonAddPosition: String,
        buttonDelete: String,
        buttonDeletePosition: String,
        prototype: String,
        prototypeName: String,
        startIndex: Number
    }

    connect() {
        this.index = this.hasStartIndexValue ? this.startIndexValue : this.entryTargets.length

        this._dispatchEvent('advanced-collection:pre-connect', {
            allowAdd: this.allowAddValue,
            allowDelete: this.allowDeleteValue,
        });

        // insert add button
        if (true === this.allowAddValue) {
            const addButton = this._htmlToElement(this.buttonAddValue);

            this.containerTarget.insertAdjacentElement(this.buttonAddPositionValue, addButton);
        }

        // insert delete button on each existing entry.
        console.log(this.allowDeleteValue, this.entryTargets)
        if (true === this.allowDeleteValue && this.entryTargets.length > 0) {
            this.entryTargets.forEach(function (element, index) {
                console.log('element', element)
                this._addDeleteButton(element, index)
            }, this);
        }

        this._dispatchEvent('advanced-collection:connect', {
            allowAdd: this.allowAddValue,
            allowDelete: this.allowDeleteValue,
        });
    }

    add(event) {
        let newEntry = this.prototypeValue;

        newEntry = newEntry.replace(new RegExp(this.prototypeNameValue, 'g'), this.index);
        newEntry = this._htmlToElement(newEntry);

        if (true === this.allowDeleteValue) {
            newEntry = this._addDeleteButton(newEntry, this.index);
        }

        this.containerTarget.appendChild(newEntry);
        this.index++;

        this._dispatchEvent('advanced-collection:add', {
            element: newEntry,
        });
    }

    delete(event) {
        let entry = event.target.closest(`[data-enhanced-collection-target="entry"]`);

        entry.remove();

        this._dispatchEvent('advanced-collection:delete', {
            element: entry,
        });
    }

    /**
     * Insert the delete button to the entry.
     *
     * @private
     *
     * @param {string} entry
     * @param {int} index
     *
     * @returns {(string|ChildNode)}
     */
    _addDeleteButton(entry, index) {
        console.log('_addDeleteButton')
        // link the button and the entry by the data-index-entry attribute
        entry.dataset.indexEntry = index;

        let buttonDelete = this._htmlToElement(this.buttonDeleteValue);

        if (!buttonDelete) {
            return entry;
        }

        buttonDelete.dataset.indexEntry = index;
        entry.insertAdjacentElement(this.buttonDeletePositionValue, buttonDelete)

        return entry;
    }

    /**
     * Convert html to Element to insert in the DOM.
     *
     * @private
     *
     * @param {string} html
     *
     * @returns {ChildNode}
     */
    _htmlToElement(html) {

        let template = document.createElement('template');

        html = html.trim(); // never return a text node of whitespace as the result
        template.innerHTML = html;

        return template.content.firstChild;
    }

    /**
     * Dispatch an event
     *
     * @private
     *
     * @param {string} name
     * @param {Object} payload
     * @param {boolean} canBubble
     * @param {boolean} cancelable
     *
     * @return {void}
     */
    _dispatchEvent(name, payload = null, canBubble = false, cancelable = false) {
        const userEvent = document.createEvent('CustomEvent');
        userEvent.initCustomEvent(name, canBubble, cancelable, payload);

        this.element.dispatchEvent(userEvent);
    }
}
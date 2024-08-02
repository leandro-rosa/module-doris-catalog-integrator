/**
 * Leandro Rosa
 *
 * NOTICE OF LICENSE
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Doris Module to newer
 * versions in the future. If you wish to customize it for your
 * needs please refer to https://developer.adobe.com/commerce/docs/ for more information.
 *
 * @category LeandroRosa
 *
 * @copyright Copyright (c) 2024 Leandro Rosa (https:www.rosa-planet.com.br)
 *
 * @author Leandro Rosa <dev.leandrorosa@gmail.com>
 */
define(
    [
        'mage/translate',
    ], function (
        __
    ) {
        'use strict';

        return {
            clearConsole: function () {
                const consoleElement = document.getElementById('doris-pipeline-console-items');
                consoleElement.innerHTML = '';
            },

            addTextToConsole: function (
                {
                    value,
                    cssClass = 'doris-info',
                    consoleElementId = 'doris-pipeline-console-items',
                    position = 'beforeend'
                }
            ) {
                const pipelineElement = document.getElementById('doris-pipeline-console');
                const consoleElement = document.getElementById(consoleElementId);
                const infoElement = document.createElement('div');

                infoElement.classList.add(cssClass);
                infoElement.classList.add('doris-console-message');
                infoElement.innerText = value


                consoleElement.insertAdjacentElement(position, infoElement);
                this.typeText(infoElement, value, 50);


                consoleElement.scrollTop = consoleElement.scrollHeight;
                pipelineElement.scrollTop = consoleElement.scrollHeight;
            },

            typeText: function (element, text, speed) {
                let index = 0;
                element.textContent = '';
                const typing = setInterval(() => {
                    if (index < text.length) {
                        element.textContent += text.charAt(index);
                        index++;
                        return;
                    }
                    clearInterval(typing);
                }, speed);
            },

            copyConsoleTextToClipboard: function () {
                if (!navigator.clipboard) {
                    console.error('Your browser does not support clipboard functionality.');
                    return;
                }
                const consoleElement = document.getElementById('doris-pipeline-console-items');
                const consoleText = consoleElement.innerText;

                navigator.clipboard.writeText(consoleText)
                    .then(() => {
                        console.debug('Copy report successfully.');
                    })
                    .catch((error) => {
                        console.error('Failed to copy text: ', error);
                    });
            },
        };
    }
);

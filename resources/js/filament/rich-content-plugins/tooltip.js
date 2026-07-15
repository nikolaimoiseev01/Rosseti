const {
    Mark,
    mergeAttributes,
} = window.FilamentRichEditor.tiptap.core;

export default Mark.create({
    name: 'tooltip',

    inclusive: false,

    parseHTML() {
        return [
            {
                tag: 'span[data-tooltip]',
            },
        ];
    },

    addAttributes() {
        return {
            text: {
                default: null,

                parseHTML: (element) => {
                    return element.getAttribute(
                        'data-tooltip'
                    );
                },

                renderHTML: (attributes) => {
                    if (!attributes.text) {
                        return {};
                    }

                    return {
                        'data-tooltip': attributes.text,
                        'aria-label': attributes.text,
                        tabindex: '0',
                    };
                },
            },
        };
    },

    renderHTML({ HTMLAttributes }) {
        return [
            'span',
            mergeAttributes(
                {
                    class: 'has-tooltip',
                },
                HTMLAttributes
            ),
            0,
        ];
    },

    addCommands() {
        return {
            setTooltip:
                (attributes) =>
                    ({ commands }) => {
                        return commands.setMark(
                            this.name,
                            attributes
                        );
                    },

            unsetTooltip:
                () =>
                    ({ commands }) => {
                        return commands.unsetMark(
                            this.name
                        );
                    },
        };
    },
});

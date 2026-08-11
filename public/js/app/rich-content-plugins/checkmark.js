const {
    Node,
    mergeAttributes,
} = window.FilamentRichEditor.tiptap.core;

export default Node.create({
    name: 'checkmark',
    
    group: 'inline',
    inline: true,
    selectable: true,
    atom: true,

    parseHTML() {
        return [
            {
                tag: 'img[data-checkmark]',
            },
        ];
    },

    renderHTML({ HTMLAttributes }) {
        return [
            'img',
            mergeAttributes(
                {
                    src: '/fixed/galochka.png',
                    'data-checkmark': 'true',
                    class: 'table-check-icon',
                    style: 'width: 1.2em; height: 1.2em; display: inline-block; vertical-align: middle; margin: 0 2px;',
                    alt: '✓'
                },
                HTMLAttributes
            ),
        ];
    },

    addCommands() {
        return {
            insertCheckmark:
                () =>
                    ({ commands }) => {
                        return commands.insertContent({
                            type: this.name,
                        });
                    },
        };
    },
});

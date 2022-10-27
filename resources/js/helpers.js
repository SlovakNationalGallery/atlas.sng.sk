const formatName = (name) => name.replace(/^([^,]*),\s*(.*)$/, '$2 $1')
const formatAuthors = (authors) => authors.map((author) => formatName(author)).join(', ')

export default {
    formatName,
    formatAuthors,
}

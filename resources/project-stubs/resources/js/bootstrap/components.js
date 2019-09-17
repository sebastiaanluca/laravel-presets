// Note the use of Webpack aliases directories instead of relative or absolute paths

const components = [
    require.context('./../../components', true, /\.vue$/i),
]

components.map(files => {
    files.keys().map(
        key => Vue.component(
            key.split('/').pop().split('.')[0],
            files(key).default
        )
    )
})

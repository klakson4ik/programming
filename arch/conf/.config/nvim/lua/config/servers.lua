return {
    lua = {
        name = 'lua_ls'
    },
    c = {
        name = "clangd"
    },
    html = {
        name = "html"
    },
    css = {
        name = 'somesass_ls'
    },
    javascript = {
        name = 'ts_ls'
    },
    json = {
        name = 'jsonls',
        settings = {
            json = {
                schemas = require('schemastore').json.schemas(),
                validate = { enable = true },
            }
        }
    },
    yaml = {
        name = 'yamlls',
        settings = {
            yaml = {
                schemaStore = {
                    enable = false,
                    url = "",
                },
                schemas = require('schemastore').yaml.schemas(),
            },
        }
    }
}

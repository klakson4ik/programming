return {
    "neovim/nvim-lspconfig",
    event = { "BufReadPre", "BufNewFile" },
    dependencies = {
        "hrsh7th/cmp-nvim-lsp",
    },
    config = function()
        local servers = require("config.settings").servers
        local lspconfig = require('lspconfig')
        local capabilities = require('cmp_nvim_lsp').default_capabilities(vim.lsp.protocol.make_client_capabilities())
        -- capabilities.textDocument.foldingRange = {
        --     dynamicRegistration = false,
        --     lineFoldingOnly = true
        -- }

        local on_attach = function(_, bufnr)
            local opts = { buffer = bufnr, noremap = true, silent = true }
            vim.keymap.set('n', 'K', vim.lsp.buf.hover, opts)
            vim.keymap.set('n', '1', function()
                vim.lsp.buf.format { async = true }
            end)
        end

        local signs = { Error = " ", Warn = " ", Hint = "󰠠 ", Info = " " }
        for type, icon in pairs(signs) do
            local hl = "DiagnosticSign" .. type
            vim.fn.sign_define(hl, { text = icon, texthl = hl, numhl = "" })
        end

        for index, server in pairs(servers) do
            lspconfig[server.name].setup {
                on_attach = on_attach,
                capabilities = capabilities,
                settings = server.settings
            }
        end
        -- require('ufo').setup()
    end
}

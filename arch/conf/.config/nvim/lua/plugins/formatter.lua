return {
    'stevearc/conform.nvim',
    opts = {},
    config = function()
        require("conform").setup({
            formatters_by_ft = {
                javascript = { "biome", stop_after_first = true },
                scss = { "prettierd", stop_after_first = true },
                html = { "prettierd", stop_after_first = true },
            },
            format_on_save = {
                lsp_format = "fallback",
            },
        })
    end
}

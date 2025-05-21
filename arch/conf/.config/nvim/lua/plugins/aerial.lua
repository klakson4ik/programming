return {
    'stevearc/aerial.nvim',
    event = 'VeryLazy',
    dependencies = {
        "nvim-treesitter/nvim-treesitter",
        "nvim-tree/nvim-web-devicons"
    },
    opts = {
        backends = { "lsp", "treesitter", "markdown", "man" },
        layout = { min_width = 48 },
        show_guides = true,
        guides = {
            mid_item = "├ ",
            last_item = "└ ",
            nested_top = "│ ",
            whitespace = "  ",
        },
        keymaps = {
            ["[["] = false,
            ["]]"] = false,
        },
    },
    config = function()
        require("aerial").setup({
            on_attach = function(bufnr)
                vim.keymap.set("n", "{", "<cmd>AerialPrev<CR>", { buffer = bufnr }, { desc = 'Aerial prev' })
                vim.keymap.set("n", "}", "<cmd>AerialNext<CR>", { buffer = bufnr }, { desc = 'Aerial next' })
            end,
        })
    end

}

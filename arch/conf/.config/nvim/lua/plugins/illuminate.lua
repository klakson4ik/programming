return {
    "RRethy/vim-illuminate",
    event = 'VeryLazy',
    opts = {
        delay = 200,
        min_count_to_highlight = 2,
        large_file_cutoff = 2000,
        large_file_overrides = { providers = { "lsp" } },
    },
    config = function()
        local ill = require('illuminate')
        vim.keymap.set('n', '<C-n>', function() ill["goto_next_reference"](false) end,
            { desc = 'Next reference' })
        vim.keymap.set('n', '<C-p>', function() ill["goto_prev_reference"](false) end,
            { desc = 'Prev reference' })
    end
}

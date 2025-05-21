return {
    "nvim-lualine/lualine.nvim",
    dependencies = { "nvim-tree/nvim-web-devicons" },
    config = function()
        local lualine = require("lualine")

        lualine.setup({
            options = {
                theme = 'dracula-nvim',
            },
            always_show_tabline = false,
            refresh = {
                statusline = 500, -- The refresh option sets minimum time that lualine tries
                tabline = 500,    -- to maintain between refresh. It's not guarantied if situation
                winbar = 10000
            },
            sections = {
                lualine_b = { 'branch' },
                lualine_c = { { 'diagnostics' }, {
                    'filename',
                    file_status = true, -- Displays file status (readonly status, modified status)
                    newfile_status = false, -- Display new file status (new file means no write after created)
                    path = 1, -- 0: Just the filename
                    shorting_target = 100, -- Shortens path to leave 40 spaces in the window
                    symbols = {
                        modified = '●', -- Text to show when the file is modified.
                        readonly = '[-]', -- Text to show when the file is non-modifiable or readonly.
                        newfile = '[new]', -- Text to show for newly created file before first write
                    }
                },
                    { 'aerial' }
                },
                lualine_x = {
                    { 'searchcount' },
                    { "encoding" },
                    { "fileformat" },
                    { "filetype" },
                    { "filesize" },
                }
            },
            tabline = {
                lualine_a = { {
                    'tabs',
                    mode = 2,
                    show_modified_status = false,
                    fmt = function(name, context)
                        local buflist = vim.fn.tabpagebuflist(context.tabnr)
                        local winnr = vim.fn.tabpagewinnr(context.tabnr)
                        local bufnr = buflist[winnr]
                        local mod = vim.fn.getbufvar(bufnr, '&mod')
                        return name .. (mod == 1 and ' ●' or '')
                    end
                } },
                lualine_b = {},
                lualine_c = {},
                lualine_x = {},
                lualine_y = {},
                lualine_z = {}
            }
        })
    end,
}

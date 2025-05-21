return {
    "nvim-tree/nvim-tree.lua",
    dependencies = { "nvim-tree/nvim-web-devicons" },
    config = function()
        local nvimtree = require('nvim-tree')
        local HEIGHT_RATIO = 0.8 -- You can change this
        local WIDTH_RATIO = 0.5  -- You can change this too

        vim.g.loaded_netrw = 1
        vim.g.loaded_netrwPlugin = 1

        vim.cmd([[ highlight NvimTreeFolderArrowClosed guifg=#3FC5FF ]])
        vim.cmd([[ highlight NvimTreeFolderArrowOpen guifg=#3FC5FF ]])

        nvimtree.setup({
            disable_netrw = true,
            hijack_netrw = true,
            respect_buf_cwd = true,
            sync_root_with_cwd = true,
            view = {
                cursorline = true,
                relativenumber = true,
                signcolumn = "no",
                float = {
                    enable = true,
                    quit_on_focus_loss = true,
                    open_win_config = function()
                        local screen_w = vim.opt.columns:get()
                        local screen_h = vim.opt.lines:get() - vim.opt.cmdheight:get()
                        local window_w = screen_w * WIDTH_RATIO
                        local window_h = screen_h * HEIGHT_RATIO
                        local window_w_int = math.floor(window_w)
                        local window_h_int = math.floor(window_h)
                        local center_x = (screen_w - window_w) / 2
                        local center_y = ((vim.opt.lines:get() - window_h) / 2)
                            - vim.opt.cmdheight:get()
                        return {
                            border = "rounded",
                            relative = "editor",
                            row = center_y,
                            col = center_x,
                            width = window_w_int,
                            height = window_h_int,
                        }
                    end
                }
            },
            diagnostics = {
                enable = true,
                show_on_dirs = true,
                show_on_open_dirs = true,
            },
            modified = {
                enable = true,
                show_on_dirs = true,
                show_on_open_dirs = true,
            },
            actions = {
                open_file = {
                   window_picker = {
                        enable = false,
                    },
                },
            },
            renderer = {
                indent_width = 1,
                add_trailing = true,
                group_empty = true,
                full_name = true,
                highlight_diagnostics = "all",
            },
            filters = {
                dotfiles = true,
            },
            git = {
                ignore = false,
            },
        })
    end,
}

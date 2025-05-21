return {
    "hrsh7th/nvim-cmp",
    event = "InsertEnter",
    dependencies = {
        "hrsh7th/cmp-buffer",           -- source for text in buffer
        "hrsh7th/cmp-path",             -- source for file system paths
        "L3MON4D3/LuaSnip",             -- snippet engine
        "saadparwaiz1/cmp_luasnip",     -- for autocompletion
        "rafamadriz/friendly-snippets", -- useful snippets
    },
    config = function()
        local cmp = require('cmp')
        local luasnip = require('luasnip')

        require("luasnip.loaders.from_vscode").lazy_load()
        local icons = {
            Array = ' ',
            Boolean = ' ',
            Class = ' ',
            Color = ' ',
            Constant = ' ',
            Constructor = ' ',
            Enum = ' ',
            EnumMember = ' ',
            Event = ' ',
            Field = ' ',
            File = ' ',
            Folder = ' ',
            Function = ' ',
            Interface = ' ',
            Key = ' ',
            Keyword = ' ',
            Method = ' ',
            Module = ' ',
            Namespace = ' ',
            Null = 'ﳠ ',
            Number = ' ',
            Object = ' ',
            Operator = ' ',
            Package = ' ',
            Property = ' ',
            Reference = ' ',
            Snippet = ' ',
            String = ' ',
            Struct = ' ',
            Text = ' ',
            TypeParameter = ' ',
            Unit = ' ',
            Value = ' ',
            Variable = ' ',
        }


        cmp.setup({
            snippet = {
                expand = function(args)
                    luasnip.lsp_expand(args.body)
                end,
            },
            formatting = {
                fields = { 'kind', 'abbr', 'menu' },
                format = function(entry, item)
                    item.kind = string.format('%s', icons[item.kind])
                    item.menu = ({
                        -- buffer = '[Buffer]',
                        luasnip = '[Snip]',
                        nvim_lsp = '[LSP]',
                        path = '[Path]',
                        -- rg = '[RG]',
                    })[entry.source.name]
                    return item
                end,
            },
            preselect = cmp.PreselectMode.None,
            window = {
                completion = cmp.config.window.bordered {
                    border = "rounded",
                    winhighlight = "Normal:NormalFloat,FloatBorder:FloatBorder,CursorLine:PmenuSel,Search:None",
                },
                documentation = cmp.config.window.bordered {
                    border = "rounded",
                    winhighlight = "Normal:NormalFloat,FloatBorder:FloatBorder,CursorLine:PmenuSel,Search:None",
                },
            },
            duplicates = {
                nvim_lsp = 1,
                luasnip = 1,
                cmp_tabnine = 1,
                buffer = 1,
                path = 1,
            },
            mapping = {
                ["<C-K>"] = cmp.mapping(cmp.mapping.select_prev_item(), { "i", "c" }),
                ["<C-J>"] = cmp.mapping(cmp.mapping.select_next_item(), { "i", "c" }),
                ["<C-P>"] = cmp.mapping(cmp.mapping.scroll_docs(-4), { "i", "c" }),
                ["<C-N>"] = cmp.mapping(cmp.mapping.scroll_docs(4), { "i", "c" }),
                ["<C-Space>"] = cmp.mapping(cmp.mapping.complete(), { "i", "c" }),
                ["<C-Y>"] = cmp.config.disable,
                ["<C-c>"] = cmp.mapping {
                    i = cmp.mapping.abort(),
                    c = cmp.mapping.close(),
                },
                ["<Tab>"] = cmp.mapping(function(fallback)
                    if luasnip.expand_or_locally_jumpable() then
                        luasnip.expand_or_jump()
                    elseif cmp.visible() then
                        cmp.confirm {
                            behavior = cmp.ConfirmBehavior.Replace,
                            select = true,
                        }
                    else
                        fallback()
                    end
                end, {
                    "i",
                    "s",
                }),
            },
            sources = cmp.config.sources({
                -- { name = 'buffer', priority = 5 },
                { name = 'nvim_lsp', priority = 3 },
                -- { name = 'rg', priority = 3 },
                { name = 'luasnip',  priority = 2 },
                { name = 'path',     priority = 1 },
            }),
        })
    end,
}

-- { border = "single", winhighlight = "Normal:Normal,FloatBorder:FloatBorder,CursorLine:Visual,Search:None" }

-- vim.api.nvim_command('hi LuasnipChoiceNodePassive cterm=italic')
-- vim.opt.completeopt = 'menu,menuone,noselect'

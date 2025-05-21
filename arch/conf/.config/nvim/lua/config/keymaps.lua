local set = vim.keymap.set
local wk = require('which-key')
-- local resession = require('resession')
-- -- Navigate vim panes better
set('n', '<c-k>', ':wincmd k<CR>')
set('n', '<c-j>', ':wincmd j<CR>')
set('n', '<c-h>', ':wincmd h<CR>')
set('n', '<c-l>', ':wincmd l<CR>')

local common = {
    { '<leader>b', "<cmd>NvimTreeFindFileToggle<CR>cr>", desc = "Toggle Explorer" },
}

local options = {
    { '<leader>o',  group = 'Options' },
    { '<leader>oi', "<cmd>IBLToggle<cr>",                          desc = "Toggle indent guides" },
    { '<leader>or', function() require("illuminate").toggle() end, desc = "Toggle reference highlighting" },

}

local helper = {
    { '<leader>h',  group = 'Helper' },
    { '<leader>hh', "<cmd>nohlsearch<cr>",    desc = "No Highlight" },
    { '<leader>ha', "<cmd>AerialToggle!<cr>", desc = "Aerial" },
    { '<leader>hi', "<cmd>IBLToggle<cr>",     desc = "Toggle indent guides" },
}

local quit = {
    { '<leader>q',  group = 'Quit' },
    { '<leader>qq', "<cmd>qall!<cr>",                            desc = "Quit without save" },
    { '<leader>qw', "<cmd>wqa<cr>",                              desc = "Wrire and quit all" },
    { '<leader>db', "<cmd>lua require'dap'.step_back()<cr>",     desc = "Step Back" },
    { '<leader>dc', "<cmd>lua require'dap'.continue()<cr>",      desc = "Continue" },
    { '<leader>dC', "<cmd>lua require'dap'.run_to_cursor()<cr>", desc = "Run To Cursor" },

}


local debug = {
    { '<leader>d',  group = 'Debug' },
    { "<leader>dB", function() require("dap").set_breakpoint(vim.fn.input('Breakpoint condition: ')) end, desc = "Breakpoint Condition" },
    { "<leader>db", function() require("dap").toggle_breakpoint() end,                                    desc = "Toggle Breakpoint" },
    { "<leader>dc", function() require("dap").continue() end,                                             desc = "Run/Continue" },
    { "<leader>da", function() require("dap").continue({ before = get_args }) end,                        desc = "Run with Args" },
    { "<leader>dC", function() require("dap").run_to_cursor() end,                                        desc = "Run to Cursor" },
    { "<leader>dg", function() require("dap").goto_() end,                                                desc = "Go to Line (No Execute)" },
    { "<leader>di", function() require("dap").step_into() end,                                            desc = "Step Into" },
    { "<leader>dj", function() require("dap").down() end,                                                 desc = "Down" },
    { "<leader>dk", function() require("dap").up() end,                                                   desc = "Up" },
    { "<leader>dl", function() require("dap").run_last() end,                                             desc = "Run Last" },
    { "<leader>do", function() require("dap").step_out() end,                                             desc = "Step Out" },
    { "<leader>dO", function() require("dap").step_over() end,                                            desc = "Step Over" },
    { "<leader>dP", function() require("dap").pause() end,                                                desc = "Pause" },
    { "<leader>dr", function() require("dap").repl.toggle() end,                                          desc = "Toggle REPL" },
    { "<leader>ds", function() require("dap").session() end,                                              desc = "Session" },
    { "<leader>dt", function() require("dap").terminate() end,                                            desc = "Terminate" },
    { "<leader>dw", function() require("dap.ui.widgets").hover() end,                                     desc = "Widgets" },
    { "<leader>du", function() require("dapui").toggle({}) end,                                           desc = "Dap UI" },
    { "<leader>de", function() require("dapui").eval() end,                                               desc = "Eval",                   mode = { "n", "v" } },
}

local git = {
    { '<leader>g',  group = 'Git' },
    -- { '<leader>g', "<cmd>lua require 'lvim.core.terminal'.lazygit_toggle()<cr>", "Lazygit" },
    { '<leader>gj', "<cmd>lua require 'gitsigns'.nav_hunk('next', {navigation_message = false})<cr>", desc = "Next Hunk" },
    { '<leader>gk', "<cmd>lua require 'gitsigns'.nav_hunk('prev', {navigation_message = false})<cr>", desc = "Prev Hunk" },
    { '<leader>gl', "<cmd>lua require 'gitsigns'.blame_line()<cr>",                                   desc = "Blame" },
    { '<leader>gL', "<cmd>lua require 'gitsigns'.blame_line({full=true})<cr>",                        desc = "Blame Line (full)" },
    { '<leader>gp', "<cmd>lua require 'gitsigns'.preview_hunk()<cr>",                                 desc = "Preview Hunk" },
    { '<leader>gr', "<cmd>lua require 'gitsigns'.reset_hunk()<cr>",                                   desc = "Reset Hunk" },
    { '<leader>gR', "<cmd>lua require 'gitsigns'.reset_buffer()<cr>",                                 desc = "Reset Buffer" },
    { '<leader>gs', "<cmd>lua require 'gitsigns'.stage_hunk()<cr>",                                   desc = "Stage Hunk" },
    { '<leader>gu', "<cmd>lua require 'gitsigns'.undo_stage_hunk()<cr>",                              desc = "Undo Stage Hunk" },
    { '<leader>go', "<cmd>Telescope git_status<cr>",                                                  desc = "Open changed file" },
    { '<leader>gb', "<cmd>Telescope git_branches<cr>",                                                desc = "Checkout branch" },
    { '<leader>gc', "<cmd>Telescope git_commits<cr>",                                                 desc = "Checkout commit" },
    { '<leader>gC', "<cmd>Telescope git_bcommits<cr>",                                                desc = "Checkout commit(for current file)" },
    { '<leader>gd', "<cmd>Gitsigns diffthis HEAD<cr>",                                                desc = "Git Diff" },
}

local lsp = {
    { '<leader>l',  group = 'LSP' },
    { '<leader>la', "<cmd>lua vim.lsp.buf.code_action()<cr>",               desc = "Code Action" },
    { '<leader>ld', "<cmd>Telescope diagnostics bufnr=0 theme=get_ivy<cr>", desc = "Buffer Diagnostics" },
    { '<leader>lw', "<cmd>Telescope diagnostics<cr>",                       desc = "Diagnostics" },
    { '<leader>lf', "<cmd>vim.lsp.buf.format()<cr>",                        desc = "Format" },
    { '<leader>lj', "<cmd>lua vim.diagnostic.goto_next()<cr>",              desc = "Next Diagnostic" },
    { '<leader>lk', "<cmd>lua vim.diagnostic.goto_prev()<cr>",              desc = "Prev Diagnostic" },
    { '<leader>ll', "<cmd>lua vim.lsp.codelens.run()<cr>",                  desc = "CodeLens Action" },
    { '<leader>lq', "<cmd>lua vim.diagnostic.setloclist()<cr>",             desc = "Quickfix" },
    { '<leader>lr', "<cmd>lua vim.lsp.buf.rename()<cr>",                    desc = "Rename" },
    { '<leader>lh', "<cmd>lua vim.lsp.buf.signature_help()<CR>",            desc = "signature_help" },
    { '<leader>le', "<cmd>Telescope quickfix<cr>",                          desc = "Telescope Quickfix" },
}

local search = {
    { '<leader>f',  group = 'Search' },
    { '<leader>ff', "<cmd>Telescope find_files<cr>",                   desc = "Find File" },
    { '<leader>fm', "<cmd>Telescope man_pages<cr>",                    desc = "Man Pages" },
    { '<leader>fo', "<cmd>Telescope oldfiles<cr>",                     desc = "Open Recent File" },
    { '<leader>ft', "<cmd>Telescope live_grep<cr>",                    desc = "Text" },
    { '<leader>fl', "<cmd>Telescope resume<cr>",                       desc = "Resume last search" },
    { '<leader>fs', "<cmd>Telescope lsp_document_symbols<cr>",         desc = "Document Symbols" },
    { '<leader>fS', "<cmd>Telescope lsp_workspace_symbols<cr>",        desc = "Workspace Symbols" },
    { '<leader>fr', "<cmd>Telescope lsp_references<cr>",               desc = "References" },
    { '<leader>fi', "<cmd>Telescope lsp_implementations<cr>",          desc = "Implementations" },
    { '<leader>fd', "<cmd>Telescope lsp_definitions<cr>",              desc = "Definitions" },
    { '<leader>fT', "<cmd>Telescope builtin.lsp_type_definitions<cr>", desc = "Type definitions" },
    { '<leader>fc', "<cmd>Telescope builtin.lsp_incoming_calls<cr>",   desc = "Incoming calls" },
    { '<leader>fC', "<cmd>Telescope builtin.lsp_outgoing_calls<cr>",   desc = "Outgoing calls" },
    { '<leader>fp', "<cmd>Telescope project<CR>",                      desc = "Projects" },
    { '<leader>fo', "<cmd>TodoTelescope<cr>",                          desc = "TODO list" },
}



local visual = {
    ["/"] = { "<Plug>(comment_toggle_linewise_visual)", "Comment toggle linewise (visual)" },
    l = {
        name = "LSP",
        a = { "<cmd>lua vim.lsp.buf.code_action()<cr>", "Code Action" },
    },
    g = {
        name = "Git",
        r = { "<cmd>Gitsigns reset_hunk<cr>", "Reset Hunk" },
        s = { "<cmd>Gitsigns stage_hunk<cr>", "Stage Hunk" },
    },
}

wk.add({ search, helper, lsp, quit, git, debug, common, options })

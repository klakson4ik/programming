return {
    'mfussenegger/nvim-dap',
    dependencies = {
        {
            'rcarriga/nvim-dap-ui',
            lazy = true,
            dependencies = {
                "nvim-neotest/nvim-nio",
                lazy = true,
            },
            opts = { floating = { border = "rounded" } },
            config = function(_, opts)
                local dap = require("dap")
                local dapui = require("dapui")
                dapui.setup(opts)
                dap.listeners.after.event_initialized["dapui_config"] = function()
                    dapui.open({})
                end
                dap.listeners.before.event_terminated["dapui_config"] = function()
                    dapui.close({})
                end
                dap.listeners.before.event_exited["dapui_config"] = function()
                    dapui.close({})
                end
            end
        },
        'theHamsta/nvim-dap-virtual-text',

    },
    config = function()
        require('dap.ext.vscode').load_launchjs(nil, {})
        local dap = require('dap')
        dap.adapters.codelldb = {
            name = "codelldb server",
            type = 'server',
            port = "${port}",
            executable = {
                command = vim.fn.stdpath("data") .. '/mason/bin/codelldb',
                args = { "--port", "${port}" },
            }
        }
        dap.configurations.cpp = {
            {
                name = "Debug",
                type = "codelldb",
                request = "launch",
                program = function()
                    return vim.fn.input('Path to executable: ', vim.fn.getcwd() .. '/', 'file')
                end,
                cwd = '${workspaceFolder}',
                stopOnEntry = false,
            },
        }
        dap.configurations.c = dap.configurations.cpp
    end
}

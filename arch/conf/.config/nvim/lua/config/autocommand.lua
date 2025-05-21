local session_util = require('core.util.session')
local session = require('resession')

vim.api.nvim_create_autocmd("VimLeavePre", {
    callback = function()
        session.save('last')
        if session_util.is_save_session() then
            session.save(session_util.get_session_name(), { dir = "dirsession", notify = false })
        end
    end,
})

vim.api.nvim_create_autocmd("VimEnter", {
    callback = function()
        if vim.fn.argc(-1) == 0 then
            if session_util.is_save_session() then
                session.load(session_util.get_session_name(), { dir = "dirsession", silence_errors = true })
            else
                local last_session_cwd = session_util.get_last_session_cwd()
                if last_session_cwd and vim.uv.cwd() ~= last_session_cwd then
                    vim.uv.chdir(last_session_cwd)
                end
                if session_util.is_exists_dirsession() then
                    session.load(session_util.get_session_name(), { dir = "dirsession", silence_errors = true })
                else
                    session.load('last', { dir = 'session' })
                end
            end
        end
    end,
    nested = true,
})

vim.api.nvim_create_autocmd({ "BufWritePost" }, {
    callback = function()
        require("lint").try_lint()
    end,
})

-- vim.api.nvim_create_autocmd("BufWritePre", {
--     callback = function()
--         vim.lsp.buf.format()
--     end,
-- })

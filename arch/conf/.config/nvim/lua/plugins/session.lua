local settnigs = require('config.settings').session

return {
    'stevearc/resession.nvim',
    config = function()
        require("resession").setup({
            autosave = settnigs.autosave,
            options = {
                "binary",
                "bufhidden",
                "buflisted",
                "diff",
                "filetype",
                "modifiable",
                "readonly",
            },
            load_detail = true,
            load_order = "modification_time",
        })
    end
}

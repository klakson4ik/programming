local func = require('core.func')
local file = require('resession.files')
local util = require('resession.util')
local session = require('resession')

local is_save_session = function()
    local document_roots = { 'Makefile' }
    local dir = vim.fn.getcwd()
    return (func.file_exists_arr(dir, document_roots) and true or false)
end

local get_session_name = function()
    local cwd = vim.fn.getcwd()
    local data = func.str_split('/', cwd)
    local res = 'd'
    for index, val in pairs(data.arr) do
        if index ~= nil and data.length - 2 < index then
            res = res .. '_' .. val
        end
    end
    return res
end

local get_last_session_cwd = function()
    local filepath = util.get_session_file('last', 'session')
    if func.file_exists(filepath) then
        local data = file.load_json_file(filepath)
        if data ~= nil and data.global.cwd ~= nil then
            return data.global.cwd
        end
    end
    return false
end

local is_exists_dirsession = function (current)
   for index, value in pairs(session.list({ dir = 'dirsession'})) do
        if current == value then
            return true
        end
   end 
    return false
end

return {
    is_save_session = is_save_session,
    get_session_name = get_session_name,
    get_last_session_cwd = get_last_session_cwd,
    is_exists_dirsession = is_exists_dirsession
}

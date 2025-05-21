local contains = function(table, val)
    for index, value in ipairs(table) do
        if value == val then
            return true
        end
    end
    return false
end

local file_exists = function(name)
    local f = io.open(name, "r")
    if f ~= nil then
        io.close(f)
        return true
    else
        return false
    end
end

local file_exists_arr = function(dir, table)
    for i, value in pairs(table) do
        if file_exists(dir .. '/' .. value) == true then
            return true
        end
    end
    return false
end

local str_split = function(sep, str)
    local arr = {}
    local length = 0
    for sub in string.gmatch(str, "([^" .. sep .. "]+)") do
        table.insert(arr, sub)
        length = length + 1
    end
    return {
        arr = arr,
        length = length
    }
end



return {
    contains = contains,
    file_exists = file_exists,
    file_exists_arr = file_exists_arr,
    str_split = str_split
}

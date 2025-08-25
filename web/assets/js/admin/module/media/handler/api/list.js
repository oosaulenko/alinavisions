import {_API} from "../../variables";
import axios from "axios";

export const handlerList = async (limit = 10, page = 1, ids = [], folder = "0") => {
    try {
        const response = await axios.get(_API.media_list, {
            params: {
                limit: limit,
                page: page,
                ids: ids,
                folder: folder
            }
        });

        return response.data;
    } catch (error) {
        return error;
    }
};

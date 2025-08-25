import {_API} from "../../../variables";
import axios from "axios";

export const handlerApiFolderList = async () => {
    try {
        const response = await axios.get(_API.folder_list, {});
        return response.data;
    } catch (error) {
        return error;
    }
};

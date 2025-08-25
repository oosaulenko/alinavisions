import {_API} from "../../../variables";
import axios from "axios";

export const handlerApiFolderAdd = async (name) => {
    try {
        const response = await axios.get(_API.folder_add, {
            params: {
                name: name
            }
        });

        return response.data;
    } catch (error) {
        return error;
    }
};

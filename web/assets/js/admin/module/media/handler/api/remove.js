import {_API} from "../../variables";
import axios from "axios";

export const handlerApiMediaRemove = async (id) => {
    try {
        const response = await axios.get(_API.media_remove, {
            params: {
                id: id
            }
        });

        return response.data;
    } catch (error) {
        return error;
    }
};

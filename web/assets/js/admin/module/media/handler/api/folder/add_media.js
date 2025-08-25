import {_API} from "../../../variables";
import axios from "axios";

export const handlerApiFolderAddMedia = async (folder_name, media_ids) => {
    try {
        const response = await axios.get(_API.folder_add_media, {
            params: {
                folder_name: folder_name,
                ids: media_ids
            }
        });

        return response.data;
    } catch (error) {
        return error;
    }
};

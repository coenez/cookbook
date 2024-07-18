import axios from "axios";
import {ref} from "vue";

export const fetchData = (url, config = {}, applicationError) => {
    return new Promise((resolve, reject)=> {
        axios.get(url, config).then((response) => {
            let result = {
                data: response.data.result ? response.data.result : response.data,
            }
            if (response.data.totalCount) {
                result.totalCount = response.data.totalCount;
            }
            resolve(result)
        }).catch(err => {
            if (applicationError) {
                applicationError.value = err.response.data
            }
            reject()
        })
    });

}
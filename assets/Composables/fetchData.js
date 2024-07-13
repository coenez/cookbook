import axios from "axios";
import {ref} from "vue";

export const fetchData = (url, config = {}, dataContainer, applicationError) => {
    const totalCount = ref(0)
    const loading = ref(true)

    axios.get(url, config).then((response) => {
        dataContainer.value = response.data.result ? response.data.result : response.data;
        if (response.data.totalCount) {
            totalCount.value = response.data.totalCount;
        }
        loading.value = false;
    }).catch(err => {
        if (applicationError) {
            applicationError.value = err.response.data
        }
        loading.value = false;
    })

    return {loading, totalCount};
}
import axios from "axios";
import {ref} from "vue";

export const fetchData = (url, config = {}, applicationError) => {
    const data = ref([])
    const totalCount = ref(0)
    const error = ref(null)
    const loading = ref(true)

    axios.get(url, config).then((response) => {
        data.value = response.data.result;
        if (response.data.totalCount) {
            totalCount.value = response.data.totalCount;
        }
        loading.value = false;
    }).catch(err => {
        error.value = err.response.data

        if (applicationError) {
            applicationError.value = err.response.data
        }
        loading.value = false;
    })

    return {data, totalCount, error, loading};
}
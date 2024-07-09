import {watch, ref} from "vue";
import {debounce} from "lodash/function";

const localSearchTerm = ref('')

//watch for the global search term change and assign the value to the localSearchTerm
export function useGlobalSearchTerm(globalSearchTerm) {
    watch(globalSearchTerm, debounce(() => {
        localSearchTerm.value = globalSearchTerm.value
    }, 1000));

    return localSearchTerm;
}



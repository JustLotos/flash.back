import fetching from "./mutations/fetching";
import getting from "./mutations/getting";
import updating from "./mutations/updating";
import creating from "./mutations/creating";
import deleting from "./mutations/deleting";

export default {
    ...fetching,
    ...creating,
    ...deleting,
    ...updating,
    ...getting,
}
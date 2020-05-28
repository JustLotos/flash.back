import fetching from "./fetching";
import creating from "./creating";
import deleting from "./deleting";
import updating from "./updating";
import getting from "./getting";

export default {
    ...fetching,
    ...creating,
    ...deleting,
    ...updating,
    ...getting,
};
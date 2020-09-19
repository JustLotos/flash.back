import {Device} from "./Types/Device";

class Application {
    private _device: Device;

    get device(): Device {
        return this._device;
    }
    set device(value: Device) {
        this._device = value;
        return this;
    }
}
export class Sidebar {
    public static OPEN = true;
    public static CLOSE = false;

    private _status: boolean;

    constructor() {
        this._status = Sidebar.CLOSE;
    }

    public open(): Sidebar {
        this._status = Sidebar.OPEN;
        return this
    }

    public close(): Sidebar {
        this._status = Sidebar.CLOSE;
        return this
    }

    public toggleStatus(): Sidebar {
        this._status === Sidebar.OPEN ? this._status = Sidebar.OPEN : this._status = Sidebar.CLOSE;
        return this;
    }

    get status(): boolean {
        return this._status;
    }

    set status(value: boolean) {
        this._status = value;
    }
}
/** Card */
export interface ICard {
    id: number,
    name: string,
    frontSide: Array<IRecord>
    backSide: Array<IRecord>
}
export interface IRecord {
    id: number;
    content: string;
}
/** Deck */
export interface IDeck {
    details: boolean | null;
    id: number;
    name: string;
    description: string | null,
    settings: IDeckSettings
    createdAt: Date | null,
    updatedAt: Date | null
}
export interface IDeckSettings {
    limitRepeat: number,
    limitLearning: number,
    difficultyIndex: number,
    startTimeInterval: number,
    minTimeInterval: number
}
export interface ITimeIntervals {
    name: string,
    value: number
}
/** Learner */
interface IProfile {
    name: IName,
    email: string,
    status: string,
    role: string
}
export interface IName {
    first: string;
    last: string;
}
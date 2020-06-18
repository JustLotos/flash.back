/** Card */
export interface ICard {
    id: number;
    name: string;
    frontSide: Array<IRecord>;
    backSide: Array<IRecord>;
    repeat?: IRepeat;
}
export interface IRecord {
    id: number;
    content: string;
}

export interface IRepeat {
    state: string;
    count: number;
    date: number;
    interval: number;
}

/** Deck */
export interface IDeck {
    id: number;
    name: string;
    description: string | null,
    settings: IDeckSettings
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
export interface ILearner {
    name: IName;
}

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
/** Repeat */
/** Discrete */
export interface IDiscreteRepeatOptions {
    forgot: IDiscreteRepeatOption;
    recognize: IDiscreteRepeatOption;
    remember: IDiscreteRepeatOption;
    know: IDiscreteRepeatOption
}
export interface IDiscreteRepeatOption {
    repeatCount: number;
    name: string;
    label: string;
    color: string;
}
export interface IDiscreteRepeatAnswer {
    cardId: number;
    status: string;
    time: number;
    date: string;
}



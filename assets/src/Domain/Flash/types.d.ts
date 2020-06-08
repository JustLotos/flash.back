export interface IName {
    first: string;
    last: string;
}

export interface ICard {
    id: number,
    name: string,
    frontSide: Array<string>
    backSide: Array<string>
}

export interface IDeck {
    id: number;
    name: string;
    description: string,
    limitRepeat: number,
    limitLearning: number,
    difficultyIndex: number,
    baseIndex: Date,
    minTime: Date
}

interface IProfile {
    name: IName,
    email: string,
    status: string,
    role: string
}
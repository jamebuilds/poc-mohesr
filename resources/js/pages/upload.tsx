import Heading from '@/components/heading';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Head } from '@inertiajs/react';

export default function Upload() {
    return (
        <>
            <Head title="Upload Credentials">
                <link rel="preconnect" href="https://fonts.bunny.net" />
                <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
            </Head>
            <div className="p-10">
                <Heading title="POC - MOHESR" />
                <div className="grid w-full max-w-sm items-center gap-3">
                    <Label htmlFor="credential">Upload a Credential</Label>
                    <Input id="credential" type="file" required name="credential" />
                </div>
            </div>
        </>
    );
}
